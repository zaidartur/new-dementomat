<?php

namespace App\Http\Controllers;

use App\Models\DataSesiSkrining;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SkriningController extends Controller
{
    public function view()
    {
        $request = Request();

        if ($request->user()->hasAnyRole(['superadmin', 'admin'])) {
            $faskes = Faskes::select('faskes_id', 'nama_faskes', 'alamat_faskes')->get();
        } else {
            $faskes = Faskes::select('faskes_id', 'nama_faskes', 'alamat_faskes')->where('faskes_id', $request->user()->faskes_id)->get();
        }

        $data = [
            'faskes'    => $faskes,
            'kecamatan' => Kecamatan::all(),
        ];

        return view('screenings.view', $data);
    }

    public function detail(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|exists:data_sesi_skrinings,uid_sesi'
        ]);

        $detail = DataSesiSkrining::with(['keluarga', 'keluarga.faskes', 'keluarga.kecamatan', 'keluarga.desa', 'kategori', 'triggeredRule', 'dataResponse', 'dataResponse.parameter'])
                ->where('uid_sesi', $request->uid)->first();
        
        return send_200('Data sesi skrining', $detail);
    }

    public function revisi_skrining(Request $request)
    {
        $request->validate([
            'uid'       => 'required|string|exists:data_sesi_skrinings,uid_sesi',
            'alasan'    => 'required|string|min:5',
        ], [
            'uid.required'      => 'ID Sesi diperlukan',
            'uid.exists'        => 'ID Sesi tidak terdaftar',
            'alasan.required'   => 'Alasan pembatalan harus diisi.',
            'alasan.min'        => 'Alasan terlalu pendek (minimal 5 karakter).'
        ]);

        return send_200('Sesi skrining berhasil dibatalkan. Status pengguna telah disesuaikan kembali.');

        $sesi = DataSesiSkrining::where('uid_sesi', $request->uid)->first();
        $user = $sesi->keluarga;

        $sesiTerbaru = DataSesiSkrining::where('uid_keluarga', $sesi->uid_keluarga)->where('status_skrining', 'valid')->latest()->first();
        if ($sesi->uid_sesi != $sesiTerbaru->uid_sesi) return send_400('Ditolak: Anda hanya dapat membatalkan data skrining yang paling terakhir/terbaru.');

        $upd = $sesi->update(['status_skrining' => 'batal', 'alasan_batal' => $request->alasan]);
        if (!$upd) return send_400('Gagal merubah status hasil skrining.');

        $skriningValidTerakhir = DataSesiSkrining::where('uid_keluarga', $user->uid_keluarga)
                                ->where('status_skrining', 'valid')
                                ->where('uid_sesi', '!=', $sesi->uid_sesi)
                                ->latest()->first();

        if ($skriningValidTerakhir) {
            if ($skriningValidTerakhir->hasil_tcm === 'positive') {
                $statusBaru = 'Dalam Pengobatan';
            } elseif ($skriningValidTerakhir->hasil_tcm === 'negative') {
                $statusBaru = 'Aman';
            } else {
                $statusBaru = 'Wajib Menghubungi Kader / Petugas Puskesmas';
            }
        } else {
            $statusBaru = null;
        }

        $save = $user->update([
            'status_tbc'        => $statusBaru,
            'tgl_mulai_obat'    => ($statusBaru == 'Dalam Pengobatan' ? $user->tgl_mulai_obat : null),
            'catatan_perubahan_status'  => Carbon::now()->locale('id')->translatedFormat('d F Y') . " - Status disesuaikan karena Pembatalan Sesi Skrining ID:" . $sesi->uid_sesi,
        ]);
        if (!$save) return send_400('Gagal merubah status terbaru pada pengguna.');

        return send_200('Sesi skrining berhasil dibatalkan. Status pengguna telah disesuaikan kembali.');
    }

    public function reset_status(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|exists:data_keluargas,uid_keluarga',
        ]);
    }

    public function ss_skrining()
    {
        $request = Request();
        $page   = intval($request->page) < 1 ? 1 : $request->page;
        $size   = $request->size ?? 10;
        $sort   = ($request->filled('sortField') && $request->sortField != 'null') ? $request->sortField : null;
        $order  = $request->sortOrder ?? 'asc';
        $faskes = (isset($request->faskes) && !empty($request->faskes)) ? $request->faskes : null;
        $kec    = (isset($request->kecamatan) && !empty($request->kecamatan)) ? $request->kecamatan : null;
        $total  = DataSesiSkrining::with('keluarga')
                ->whereHas('keluarga', function($q) {
                    $q->whereNull('deleted_at');
                })
                ->orderBy('created_at')->whereNull('deleted_at')->count();

        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id,deleted_at', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa'])->withCount(['isYes', 'isNo']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('keluarga', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%");
            });
        }

        if (!empty($faskes)) {
            $query->whereHas('keluarga', function($que) use ($faskes) {
                $que->where('id_faskes', $faskes);
            });
        }
        if (!empty($kec)) {
            $query->whereHas('keluarga', function($que) use ($kec) {
                $que->where('kec_id', $kec);
            });
        }

        if (!empty($sort)) {
            if ($sort == 'nama') {
                $query->whereHas('keluarga', function($q) use ($order) {
                    $q->orderBy('nama_lengkap', $order);
                });
            } elseif ($sort == 'tanggal') {
                $query->orderBy('created_at', $order);
            } elseif ($sort == 'kecamatan') {
                $query->whereHas('keluarga.kecamatan', function($q) use ($order) {
                    $q->orderBy('kec_name', $order);
                });
            } elseif ($sort == 'hasil') {
                $query->where('value_triggered_rule', $order);
            } elseif ($sort == 'faskes') {
                $query->whereHas('keluarga.faskes', function($q) use ($order) {
                    $q->orderBy('nama_faskes', $order);
                });
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $query->whereNull('deleted_at');
        $query->whereHas('keluarga', function($q) {
            $q->whereNull('deleted_at');
        });
        $totalFiltered = $query->count();
        // $query->orderBy('created_at', 'desc');
        $query->skip(intval($page)-1)->take(intval($size));
        $totals = $query->get();
        $result = collect($totals)->map(function($record) {
            $user_uid = $record->uid_keluarga;

            $cleanHex = str_replace('-', '', $user_uid);
            $hexSegment = substr($cleanHex, 0, 6);
            $decValue = hexdec($hexSegment);
            $hue = $decValue % 360;
            $record->color = hslToHex($hue, 80, 45);

            return $record;
        });
        
        $data   = [];
        $latestSessionIds = DataSesiSkrining::where('status_skrining', 'valid')->selectRaw('MAX(uid_sesi) AS uid')->groupBy('uid_keluarga')->pluck('uid')->toArray();
        
        foreach ($result as $value) {
            $nik = $request->nik == 'show' ? ($value->keluarga->nik ?? '-') : (!empty($value->keluarga->nik) ? substr($value->keluarga->nik, 0, 4) . str_repeat("*", strlen($value->keluarga->nik) - 4) : '-');
            $data[] = [
                'nik'       => $nik,
                'color'     => $value->color,
                'nama'      => $value->keluarga->nama_lengkap,
                'kec'       => $value->keluarga->kecamatan->kec_name,
                'desa'      => $value->keluarga->desa->desakel_name,
                'tanggal'   => Carbon::parse($value->created_at)->locale('id')->translatedFormat('d F Y'),
                'hasil'     => $value->triggered_rule_id ? $value->triggeredRule->rekomendasi : 'Aman',
                'faskes'    => $value->keluarga->faskes->nama_faskes,
                'status'    => $value->keluarga->status_tbc,
                'sesi'      => $value->uid_sesi,
                'skor'      => '<span class="text-red-500">' . ($value->is_yes_count . '</span> / ' . ($value->is_yes_count + $value->is_no_count)),
                'opsi'      => '
                        <span class="inline-flex gap-2.5">
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_detail(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Lihat Detail '. $value->keluarga->nama_lengkap .'</span>
                                </span>
                            </a>'.
                            ((!empty($value->triggeredRule)) ? 
                                '<a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-primary" onclick="_reset_status(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                    <i class="ki-filled ki-update-file text-lg"></i>
                                    <span data-kt-tooltip-content="true" class="kt-tooltip">
                                        <span class="flex items-center gap-1.5">Revisi Status TBC '. $value->keluarga->nama_lengkap .'</span>
                                    </span>
                                </a>' .
                                (in_array($value->uid_sesi, $latestSessionIds) ? '
                                <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_reset_hasil(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                    <i class="ki-filled ki-cross-circle text-lg"></i>
                                    <span data-kt-tooltip-content="true" class="kt-tooltip">
                                        <span class="flex items-center gap-1.5">Batalkan Skrining Ini</span>
                                    </span>
                                </a>' : '')
                             : '') .
                        '</span>
                ',
            ];
        }

        return response()->json([
            'draw' => intval($request->draw) ?? 0,
            'recordsTotal'  => $total,
            'recordsFiltered' => $totalFiltered,
            'data'          => $data,
            'page'          => $page,
            'size'          => $size,
        ]);
    }
}
