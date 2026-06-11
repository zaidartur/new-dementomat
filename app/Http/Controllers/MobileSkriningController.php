<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataResponseSkrining;
use App\Models\DataRuleSkrining;
use App\Models\DataSesiSkrining;
use App\Models\MasterKategoriSkrining;
use App\Models\MasterParameterSkrining;
use App\Models\PantauanBeratBadan;
use App\Models\PantauanObat;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            return response()->json([
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
            'Wajib Menghubungi Kader (Petugas) Puskesmas',
            'Menunggu Tes Dahak',
            'Menunggu Verifikasi Admin atau Petugas',
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
            'lokasi'    => 'nullable',
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
            'Wajib Menghubungi Kader (Petugas) Puskesmas', 
            'Menunggu Tes Dahak', 
            'Menunggu Verifikasi Admin atau Petugas',
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
                'location'      => !empty($request->lokasi) ? $request->lokasi : null,
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
                    'lokasi'    => $request->lokasi,
                    'user'      => [
                        'uid_keluarga'  => $session->keluarga->uid_keluarga,
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

        $history = DataSesiSkrining::with(['keluarga:uid_keluarga,nama_lengkap,status_keluarga,status_tbc,id_faskes', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes', 'keluarga.faskes.kontak'])
                    ->whereNull('deleted_at')
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
                'lokasi'    => $session->location,
                'user'      => [
                    'uid_keluarga'  => $session->keluarga->uid_keluarga,
                    'nama'      => $session->keluarga->nama_lengkap,
                    'hubungan'  => $session->keluarga->status_keluarga,
                    'usia_saat_tes'  => $session->umur_saat_skrining,
                    'status_tbc'=> $session->keluarga->status_tbc ?? 'Belum ada status',
                    'tgl_tcm'   => !empty($session->tgl_tcm) ? Carbon::parse($session->tgl_tcm)->locale('id')->translatedFormat('d F Y') : null,
                    'jenis_tcm' => !empty($session->jenis_tcm) ? ($session->jenis_tcm === 'faskes' ? $session->keluarga->faskes->nama_faskes : 'Mandiri') : null,
                    'url_file_tcm' => !empty($session->file_tcm) ? (route('tcm.file', Crypt::encryptString($session->uid_sesi))) : null,
                ],
                'kategori'  => $session->kategori->nama_kategori,
                'status_rujuk' => $session->triggered_rule_id ? true : false,
                'rekomendasi'  => $session->triggered_rule_id ? $session->triggeredRule->rekomendasi : 'Aman. Tetap jaga kesehatan dan pola hidup bersih.',
                'kontak'    => $session->keluarga->faskes->kontak ?? [],
            ];
        });

        $history->setCollection($formattedHistory);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Data riwayat skrining user dan keluarga.',
            'data'      => $history,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function detail_skrining(Request $request)
    {
        $request->validate([
            'uid_sesi'   => 'required|string|exists:data_sesi_skrinings,uid_sesi'
        ]);

        $detail = DataSesiSkrining::with(['keluarga', 'keluarga.faskes', 'keluarga.kecamatan', 'keluarga.desa', 'kategori', 'triggeredRule', 'dataResponse', 'dataResponse.parameter'])
                ->withCount(['isYes', 'isNo'])
                ->where('uid_sesi', $request->uid_sesi)->first();

        $usia  = !empty($detail->keluarga->tgl_lahir) ? Carbon::parse($detail->keluarga->tgl_lahir) : null;
        $detail->umur_detail_saat_skrining = !empty($usia) ? CarbonInterval::instance($usia->diff(Carbon::parse($detail->created_at)))->locale('id')->forHumans(['parts' => 4, 'join' => ' ']) : null;
        
        return send_200('Detail riwayat skrining', $detail);
    }

    public function submit_dahak(Request $request)
    {
        $request->validate([
            'uid_sesi'  => 'required|string|min:35|max:36',
            'pilihan'   => 'required|string|in:faskes,mandiri',
            'dokumen'   => 'required_if:pilihan,mandiri|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal'   => 'required_if:pilihan,mandiri|date',
        ]);

        $sesi = DataSesiSkrining::where('uid_sesi', $request->uid_sesi)->whereNull('deleted_at')->first();
        if (!$sesi) return send_400('Data hasil skrining tidak diketahui.');
        $user = $sesi->uid_keluarga;

        if ($request->pilihan == 'faskes') {
            $sesi->update(['jenis_tcm' => 'faskes']);
            DataKeluarga::where('uid_keluarga', $user)->update(['status_tbc' => 'Menunggu Tes Dahak']);

            return send_200('Pilihan tersimpan. Silakan datang ke Puskesmas terdekat.');
        }
        if ($request->pilihan == 'mandiri') {
            if (!is_dir(public_path('storage/dokumen_tcm'))) {
                // mkdir(public_path('storage/dokumen_tcm', 755));
                File::makeDirectory(public_path('storage/dokumen_tcm'), 0755, true);
            }

            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $fileName  = $user . '_' . date('YmdHis') . '.' . strtolower($extension);
            $path = $file->storeAs('dokumen_tcm', $fileName, 'public');
            if (!$path) return send_400('Gagal mengunggah file dokumen.');

            $sesi->update([
                'jenis_tcm' => 'mandiri',
                'tgl_tcm'   => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'file_tcm'  => $fileName,
            ]);
            DataKeluarga::where('uid_keluarga', $user)->update(['status_tbc' => 'Menunggu Verifikasi Admin atau Petugas']);

            return send_200('Dokumen berhasil diunggah. Mohon tunggu verifikasi dari petugas.');
        }
    }

    public function file_dahak($uid)
    {
        $request = Request();
        if (! $request->user()->hasRole('user')) return null;
        try {
            $id  = Crypt::decryptString($uid);
            if (!$id) return abort(404);

            $sesi = DataSesiSkrining::where('uid_sesi', $id)->whereNull('deleted_at')->whereNotNull('file_tcm')->first();
            if (!$sesi) return null;

            $location = public_path('storage/dokumen_tcm/' . $sesi->file_tcm);
            if (!file_exists($location)) return null;

            return response()->file($location);
        } catch (Exception $e) {
            // return response()->json($e);
            return null;
        }
    }

    public function list_efek(Request $request)
    {
        $request->validate([
            'uuid'   => 'required|string|exists:data_keluargas,uid_keluarga'
        ]);

        $user = DataKeluarga::where('uid_keluarga', $request->uuid)->first();
        if (!$user) return send_400('Pengguna tidak terdaftar.');

        if ($user->status_tbc != 'Dalam Pengobatan') return send_400('Anda sedang tidak dalam masa pengobatan aktif.');

        // $tanggal    = now()->format('Y-m-d');
        // $tanggal    = Carbon::parse($request->tanggal)->format('Y-m-d');
        // $sudah_isi  = PantauanObat::where('uid_keluarga', $request->uuid)->whereDate('tanggal', $tanggal)->exists();
        // if ($sudah_isi) return send_400('Anda sudah mengisi pemantauan gejala tanggal ' . $tanggal . '.');
        
        $lists = [
            ['name' => 'mual', 'label'  => 'Efek Mual'],
            ['name' => 'pipis', 'label' => 'Efek Pipis Merah'],
            ['name' => 'pendengaran', 'label'  => 'Efek Pendengaran'],
            ['name' => 'penglihatan', 'label'  => 'Efek Penglihatan'],
            ['name' => 'pegal', 'label'  => 'Efek Pegal'],
            ['name' => 'batuk', 'label'  => 'Efek Batuk'],
            ['name' => 'demam', 'label'  => 'Efek Demam'],
        ];

        return send_200('Daftar parameter efek samping', $lists);
    }

    public function submit_log_obat(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|exists:data_keluargas,uid_keluarga',
            'id_sesi'   => 'required|string|exists:data_sesi_skrinings,uid_sesi',
            'tanggal'   => 'required|date',
            'gejala'    => 'nullable',
            'mual'      => 'required|boolean',
            'pipis'     => 'required|boolean',
            'pendengaran' => 'required|boolean',
            'penglihatan' => 'required|boolean',
            'pegal'     => 'required|boolean',
            'batuk'     => 'required|boolean',
            'demam'     => 'required|boolean',
        ]);

        $user = DataKeluarga::where('uid_keluarga', $request->uuid)->first();
        if (!$user) return send_400('Pengguna tidak terdaftar.');

        if ($user->status_tbc != 'Dalam Pengobatan') return send_400('Anda sedang tidak dalam masa pengobatan aktif.');

        // $hari_ini   = now()->format('Y-m-d');
        $tanggal    = Carbon::parse($request->tanggal)->format('Y-m-d');
        $sudah_isi  = PantauanObat::where('uid_keluarga', $request->uuid)->whereDate('tanggal', $tanggal)->exists();
        if ($sudah_isi) return send_400('Anda sudah mengisi pemantauan gejala tanggal ' . $tanggal . '.');

        $data = [
            'uid_keluarga'  => $user->uid_keluarga,
            'uid_sesi'      => $request->id_sesi,
            'tanggal'       => $tanggal,
            'gejala_awal'   => $request->gejala,
            'efek_mual'     => $request->mual,
            'efek_pipis_merah' => $request->pipis,
            'efek_pendengaran' => $request->pendengaran,
            'efek_penglihatan' => $request->penglihatan,
            'efek_pegal'    => $request->pegal,
            'efek_batuk'    => $request->batuk,
            'efek_demam'    => $request->demam
        ];

        $save = PantauanObat::create($data);
        if (!$save) return send_400('Gagal menyimpan data pemantauan gejala.');

        return send_201('Pemantauan harian berhasil dicatat. Terima kasih!');
    }

    public function submit_berat_badan(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|exists:data_keluargas,uid_keluarga',
            'id_sesi'   => 'required|string|exists:data_sesi_skrinings,uid_sesi',
            'berat'     => 'required|decimal:2',
        ]);

        $user = DataKeluarga::where('uid_keluarga', $request->uuid)->first();
        if (!$user) return send_400('Pengguna tidak terdaftar.');

        if ($user->status_tbc != 'Dalam Pengobatan') return send_400('Anda sedang tidak dalam masa pengobatan aktif.');
        $start = Carbon::parse($user->tgl_mulai_obat);
        $today = Carbon::now();

        $bulanKe = intval($start->diffInMonths($today) + 1);
        if ($bulanKe > 6) {
            return send_400('Masa program pemantauan pengobatan 6 bulan Anda telah selesai.');
        }

        $cekBulan = PantauanBeratBadan::where('uid_keluarga', $user->uid_keluarga)->where('bulan_ke', $bulanKe)->exists();
        if ($cekBulan) return send_400("Anda sudah menginput berat badan untuk Bulan ke-{$bulanKe}. Silakan input kembali di bulan depan.");

        $data = [
            'uid_keluarga'  => $user->uid_keluarga,
            'bulan_live'    => date('m'),
            'bulan_ke'      => $bulanKe,
            'berat_badan'   => ($request->berat),
        ];
        $save = PantauanBeratBadan::create($data);
        if (!$save) return send_400('Gagal menyimpan data berat badan Anda.');

        return send_201(
            "Berat badan Bulan ke-{$bulanKe} berhasil disimpan.", 
            [
                'bulan_ke' => $bulanKe,
                'berat_badan' => ($request->berat),
                'tanggal' => date('Y-m-d')
            ]
        );
    }

    public function logs_pemantauan_obat(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|exists:data_keluargas,uid_keluarga',
            'uid_sesi'  => 'required|string|exists:data_sesi_skrinings,uid_sesi'
        ]);

        $lists = PantauanObat::where('uid_keluarga', $request->uuid)->where('uid_sesi', $request->uid_sesi)->orderBy('created_at', 'desc')->get();
        $logs  = collect($lists)->map(function($query) {
            $detail = [
                ['name' => 'mual', 'label'  => 'Efek Mual', 'result' => $query->efek_mual],
                ['name' => 'pipis', 'label' => 'Efek Pipis Merah', 'result' => $query->efek_pipis_merah],
                ['name' => 'pendengaran', 'label'  => 'Efek Pendengaran', 'result' => $query->efek_pendengaran],
                ['name' => 'penglihatan', 'label'  => 'Efek Penglihatan', 'result' => $query->efek_penglihatan],
                ['name' => 'pegal', 'label'  => 'Efek Pegal', 'result' => $query->efek_pegal],
                ['name' => 'batuk', 'label'  => 'Efek Batuk', 'result' => $query->efek_batuk],
                ['name' => 'demam', 'label'  => 'Efek Demam', 'result' => $query->efek_demam],
            ];
            $query->detail = $detail;

            return $query;
        });

        return send_200('Daftar riwayat pemantauan obat', $logs);
    }

    public function logs_berat_badan(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|exists:data_keluargas,uid_keluarga',
            'uid_sesi'  => 'required|string|exists:data_sesi_skrinings,uid_sesi'
        ]);

        $lists = PantauanBeratBadan::where('uid_keluarga', $request->uuid)->where('uid_sesi', $request->uid_sesi)->orderByDesc('bulan_ke')->get();

        return send_200('Daftar riwayat pemantauan obat', $lists);
    }
}
