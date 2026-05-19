<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataSesiSkrining;
use App\Models\Faskes;
use App\Models\Kecamatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CekDahakController extends Controller
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
        return view('tcm.view', $data);
    }

    public function verifikasi_hasil(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|exists:data_sesi_skrinings,uid_sesi',
            'status'=> 'required|in:positive,negative'
        ]);

        $sesi = DataSesiSkrining::where('uid_sesi', $request->uid)->whereNull('deleted_at')->first();
        if (!$sesi || empty($sesi)) return send_400('ID skrining tidak diketahui.');

        if (empty($sesi->file_tcm)) return send_400('Mohon untuk mengunggah file hasil TCM dahulu');

        $sesi->hasil_tcm = $request->status;
        $save = $sesi->save();
        if (!$save) return send_400('Gagal melakukan verifikasi.');

        if ($request->status == 'positive') {
            $user = DataKeluarga::where('uid_keluarga', $sesi->uid_keluarga)->update(['status_tbc' => 'Dalam Pengobatan']);
        } else {
            $user = DataKeluarga::where('uid_keluarga', $sesi->uid_keluarga)->update(['status_tbc' => 'Aman']);
        }

        return send_200('Berhasil verifikasi.');
    }

    public function ss_dahak()
    {
        $request = Request();
        $page   = intval($request->page) < 1 ? 1 : $request->page;
        $size   = $request->size ?? 10;
        $sort   = ($request->filled('sortField') && $request->sortField != 'null') ? $request->sortField : null;
        $order  = $request->sortOrder ?? 'asc';
        $faskes = (isset($request->faskes) && !empty($request->faskes)) ? $request->faskes : null;
        $kec    = (isset($request->kecamatan) && !empty($request->kecamatan)) ? $request->kecamatan : null;
        $total  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa'])
                ->whereNotNull('jenis_tcm')
                ->whereHas('keluarga', function($q) {
                    $q->whereIn('status_tbc', ['Menunggu Verifikasi Admin/Petugas', 'Menunggu Tes Dahak', 'Dalam Pengobatan', 'Aman']);
                })->count();

        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa']);
        
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
            } elseif ($sort == 'faskes') {
                $query->whereHas('keluarga.faskes', function($q) use ($order) {
                    $q->orderBy('nama_faskes', $order);
                });
            } elseif ($sort == 'jenis') {
                $query->orderBy('jenis_tcm', $order);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }


        $query->whereNotNull('jenis_tcm')
            ->whereHas('keluarga', function($q) {
                $q->whereIn('status_tbc', ['Menunggu Verifikasi Admin/Petugas', 'Menunggu Tes Dahak', 'Dalam Pengobatan', 'Aman']);
            })
            ->whereNull('deleted_at');
        $totalFiltered = $query->count();
        $query->skip(intval($page)-1)->take(intval($size));
        $totals = $query->get();
        $data = [];

        foreach ($totals as $key => $value) {
            $nik = $request->nik == 'show' ? ($value->keluarga->nik ?? '-') : (!empty($value->keluarga->nik) ? substr($value->keluarga->nik, 0, 4) . str_repeat("*", strlen($value->keluarga->nik) - 4) : '-');
            $data[] = [
                'nik'       => $nik,
                'nama'      => $value->keluarga->nama_lengkap,
                'kec'       => $value->keluarga->kecamatan->kec_name,
                'desa'      => $value->keluarga->desa->desakel_name,
                'tanggal'   => Carbon::parse($value->created_at)->locale('id')->translatedFormat('d F Y'),
                'hasil'     => $value->triggered_rule_id ? $value->triggeredRule->rekomendasi : 'Aman',
                'jenis'     => $value->jenis_tcm,
                'dokumen'   => $value->jenis_tcm == 'mandiri' ? asset('storage/dokumen_tcm/' . $value->file_tcm) : (empty($value->file_tcm) ? null : asset('storage/dokumen_tcm/' . $value->file_tcm)),
                'faskes'    => $value->keluarga->faskes->nama_faskes,
                'status'    => $value->keluarga->status_tbc,
                'verif'     => empty($value->hasil_tcm) ? false : true,
                'hasil_tcm' => $value->hasil_tcm,
                'uid'       => $value->uid_sesi,
                'opsi'      => '
                        <span class="inline-flex gap-2.5">
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_detail(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Lihat Detail</span>
                                </span>
                            </a>
                        '. (empty($value->hasil_tcm) ? '
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-primary" onclick="_verifikasi(`' .$value->uid_sesi. '`, `' .$value->keluarga->nama_lengkap. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-question text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Verifikasi Data</span>
                                </span>
                            </a>' : '
                            <span class="kt-badge kt-badge-xl kt-badge-success py-3.5" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-verify text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Sudah Verifikasi</span>
                                </span>
                            </span>
                            ') .
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
