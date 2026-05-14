<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataResponseSkrining;
use App\Models\DataRuleSkrining;
use App\Models\DataSesiSkrining;
use App\Models\MasterKategoriSkrining;
use App\Models\MasterParameterSkrining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MobileSkriningController extends Controller
{
    public function show_parameter(Request $request)
    {
        $request->validate([
            'uuid'  => 'required|string|min:35|max:36',
        ]);

        if ($request->uuid == $request->user()->uuid) {
            // user auth
            $user = DataKeluarga::where('uid_keluarga', $request->uuid)->where('is_auth', 1)->first();
        } else {
            // user keluarga
            $user = DataKeluarga::where('uid_keluarga', $request->uuid)->where('is_auth', 0)->where('parent_user', $request->user()->uuid)->first();
        }

        if (!$user) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Data tidak ditemukan.'
            ], 400);
        }

        if (empty($user->nik) || empty($user->alamat_nik) || empty($user->alamat) || empty($user->tgl_lahir) || empty($user->jenkel) || empty($user->kec_id) || empty($user->desakel_id)) {
                'status'    => 'failed',
                'message'   => 'Mohon untuk melengkapi biodata terlebih dahulu.'
            ], 400);
        }

        // cek jika sudah pernah melakukan skrining dalam 7 hari terakhir
        $lastSession = DataSesiSkrining::where('uid_keluarga', $user->uid_keluarga)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastSession) {
            $tanggalBisaSkrining = !empty($lastSession->created_at) ? Carbon::parse($lastSession->created_at)->addDays(7)->locale('id')->translatedFormat('d F Y') : Carbon::parse('now')->locale('id')->translatedFormat('d F Y');
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Anda sudah melakukan skrining dalam 7 hari terakhir. Cobalah lagi setelah ' . $tanggalBisaSkrining,
            ], 403);
        }

        // BLOKIR JIKA STATUS MEDIS SEDANG AKTIF
        $statusTerkunci = [
            'Wajib Menghubungi Kader / Petugas Puskesmas', 
            'Menunggu Tes Dahak', 
            'Dalam Pengobatan'
        ];
        if (in_array($user->status_tbc, $statusTerkunci)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => "{$user->nama_lengkap} sedang berstatus {$user->status_tbc}. Tidak perlu melakukan skrining awal lagi."
            ], 403);
        }

        $usia = !empty($user->tgl_lahir) ? Carbon::parse($user->tgl_lahir)->age : 0;

        $kategori   = MasterKategoriSkrining::where('min_age', '<=', $usia)->where('max_age', '>=', $usia)->firstOrFail();
        $parameter  = MasterParameterSkrining::where('kategori_id', $kategori->id)->orderBy('id', 'asc')->get()->makeHidden(['id', 'kategori_id']);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Data parameter ' . $kategori->nama_kategori,
            'data'      => $parameter,
        ], 200);
    }

    public function save_parameter(Request $request)
    {
        $validated = $request->validate([
            'uuid'      => 'required|string|min:35|max:36',
            'parameter' => 'required|array',
            'parameter.*.uid_parameter' => 'required|string|min:35|max:36',
            'parameter.*.is_yes' => 'required|boolean',
        ]);

        // cek jika sudah pernah melakukan skrining dalam 7 hari terakhir
        $lastSession = DataSesiSkrining::where('uid_keluarga', $request->uuid)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastSession) {
            $tanggalBisaSkrining = !empty($lastSession->created_at) ? Carbon::parse($lastSession->created_at)->addDays(7)->locale('id')->translatedFormat('d F Y') : Carbon::parse('now')->locale('id')->translatedFormat('d F Y');
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Anda sudah melakukan skrining dalam 7 hari terakhir. Cobalah lagi setelah ' . $tanggalBisaSkrining,
            ], 403);
        }

        // BLOKIR JIKA STATUS MEDIS SEDANG AKTIF
        $check = DataKeluarga::where('uid_keluarga', $request->uuid)->first();
        $statusTerkunci = [
            'Wajib Menghubungi Kader / Petugas Puskesmas', 
            'Menunggu Tes Dahak', 
            'Dalam Pengobatan'
        ];
        if (in_array($check->status_tbc, $statusTerkunci)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => "{$check->nama_lengkap} sedang berstatus {$check->status_tbc}. Tidak perlu melakukan skrining awal lagi."
            ], 403);
        }

        return DB::transaction(function () use ($validated, $request) {
            if ($validated['uuid'] == $request->user()->uuid) {
                // user auth
                $user = DataKeluarga::where('uid_keluarga', $validated['uuid'])->where('is_auth', 1)->first();
            } else {
                // user keluarga
                $user = DataKeluarga::where('uid_keluarga', $validated['uuid'])->where('is_auth', 0)->where('parent_user', $request->user()->uuid)->first();
            }

            $usia = !empty($user->tgl_lahir) ? Carbon::parse($user->tgl_lahir)->age : 0;
            $kategori   = MasterKategoriSkrining::where('min_age', '<=', $usia)->where('max_age', '>=', $usia)->firstOrFail();
            $session    = DataSesiSkrining::create([
                'uid_sesi'      => Str::uuid(),
                'uid_keluarga'  => $user->uid_keluarga,
                'umur_saat_skrining' => $usia,
                'kategori_id'   => $kategori->id,
                'triggered_rule_id'  => null,
            ]);

            $yesParameterIds = [];
            $responsesToInsert = [];

            // 2. EKSTRAKSI DATA DARI ARRAY OF OBJECTS (Perubahan Utama Kedua)
            foreach ($validated['parameter'] as $param) {
                // Ekstrak nilai dari masing-masing kunci array
                $parameterId = $param['uid_parameter'];
                if (!MasterParameterSkrining::where('uid_parameter', $param['uid_parameter'])->exists()) {
                    continue;
                }
                
                // Pastikan nilai di-casting menjadi boolean murni PHP
                // (Berjaga-jaga jika dari klien terkirim string "1" atau "0")
                $isYes = filter_var($param['is_yes'], FILTER_VALIDATE_BOOLEAN); 

                $responsesToInsert[] = [
                    'sesi_uid'      => $session->uid_sesi,
                    'parameter_uid' => $parameterId,
                    'is_yes'       => $isYes,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];

                // Hanya kumpulkan ID parameter yang dijawab "YA" untuk dievaluasi oleh mesin aturan
                if ($isYes) {
                    $yesParameterIds[] = $parameterId;
                }
            }

            DataResponseSkrining::insert($responsesToInsert);

            // 3. EVALUASI ATURAN DINAMIS (Tetap Sama Persis)
            $rules = DataRuleSkrining::with('rule_kondisi')
                ->where('kategori_id', $kategori->id)
                ->get();

            $triggeredRuleId = null;

            foreach ($rules as $rule) {
                $requiredParameters = $rule->rule_kondisi->pluck('parameter_uid')->toArray();

                // Cek apakah parameter yang wajib ada, semuanya terjawab Ya oleh pasien
                if (!empty($requiredParameters) && empty(array_diff($requiredParameters, $yesParameterIds))) {
                    $triggeredRuleId = $rule->uid_rule;
                    break; 
                }
            }

            if ($triggeredRuleId) {
                $session->update(['triggered_rule_id' => $triggeredRuleId]);
            }

            // return response()->json([
            //     'status'         => 'success',
            //     'is_referred'    => !is_null($triggeredRuleId),
            //     'rule_triggered' => $triggeredRuleId,
            // ], 201);

            // 7. LOAD RELASI UNTUK RESPONSE (Penambahan Baru)
            // Tarik data relasi ke dalam object $session saat ini
            $session->load([
                'keluarga:uid_keluarga,nama_lengkap,nik,status_keluarga',
                'kategori:id,nama_kategori',
                'triggeredRule:uid_rule,nama_aturan,rekomendasi'
            ]);

            DataKeluarga::where('uid_keluarga', $request->uuid)->update(['status_tbc' => ($session->triggered_rule_id ? $session->triggeredRule->rekomendasi : 'Aman')]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data skrining berhasil di simpan.',
                'data'      => [
                    'uid_sesi'  => $session->uid_sesi,
                    'tanggal'   => Carbon::parse($session->created_at)->locale('id')->translatedFormat('d F Y, H:i'),
                    'user'      => [
                        'nama'      => $session->keluarga->nama_lengkap,
                        'hubungan'  => $session->keluarga->status_keluarga,
                        'usia_saat_tes' => $session->umur_saat_skrining,
                    ],
                    'kategori'  => $session->kategori->nama_kategori,
                    'status_rujuk' => $session->triggered_rule_id ? true : false,
                    'rekomendasi'  => $session->triggered_rule_id ? $session->triggeredRule->rekomendasi : 'Aman. Tetap jaga kesehatan dan pola hidup bersih.'
                ]
            ], 201);
        });
    }

    public function riwayat_skrining(Request $request)
    {
        $userId = $request->user()->uuid;

        $history = DataSesiSkrining::with(['keluarga:uid_keluarga,nama_lengkap,status_keluarga,status_tbc', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi'])
                    ->whereHas('keluarga', function($query) use ($userId) {
                        $query->where('parent_user', $userId)
                            ->orWhere('uid_keluarga', $userId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        $formattedHistory = $history->getCollection()->map(function ($session) {
            return [
                'uid_sesi'  => $session->uid_sesi,
                'tanggal'   => Carbon::parse($session->created_at)->locale('id')->translatedFormat('d F Y, H:i'),
                'user'      => [
                    'nama'      => $session->keluarga->nama_lengkap,
                    'hubungan'  => $session->keluarga->status_keluarga,
                    'usia_saat_tes'  => $session->umur_saat_skrining,
                    'status_terkini' => $session->keluarga->status_tbc ?? 'Belum ada status'
                ],
                'kategori'  => $session->kategori->nama_kategori,
                'status_rujuk' => $session->triggered_rule_id ? true : false,
                'rekomendasi'  => $session->triggered_rule_id ? $session->triggeredRule->rekomendasi : 'Aman. Tetap jaga kesehatan dan pola hidup bersih.'
            ];
        });

        $history->setCollection($formattedHistory);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Data riwayat skrining user dan keluarga.',
            'data'      => $history,
        ], 200);
    }
}
