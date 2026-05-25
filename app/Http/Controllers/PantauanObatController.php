<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataSesiSkrining;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\PantauanBeratBadan;
use App\Models\PantauanObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PantauanObatController extends Controller
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
        return view('screenings.pemantauan_obat', $data);
    }

    public function detail_user(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|exists:data_keluargas,uid_keluarga',
        ]);

        $user = DataKeluarga::with(['desa', 'kecamatan', 'faskes'])->where('uid_keluarga', $request->uid)->whereNull('deleted_at')->first();

        // berat badan
        $berat = PantauanBeratBadan::where('uid_keluarga', $user->uid_keluarga)->orderBy('bulan_ke')->get()->keyBy('bulan_ke');
        $last_bulan = PantauanBeratBadan::where('uid_keluarga', $user->uid_keluarga)->orderBy('bulan_ke', 'desc')->first();
        $data_berat = [];
        $label_berat = [];
        for ($i=1; $i < 7; $i++) { 
            $label_berat[] = 'Bulan ke ' . $i;
            if ($berat->has($i)) {
                $jml = $berat->get($i)->berat_badan;
                // $data_berat['Bulan ke ' . $i][] = floatval($jml);
                $data_berat[] = floatval($jml);
            } else {
                // $data_berat['Bulan ke ' . $i][] = 0;
                $data_berat[] = 0;
            }
        }


        $bulan_ke   = $request->input('bulan_ke', ($last_bulan->bulan_ke ?? 1));
        $tgl_mulai_obat = Carbon::parse($user->tgl_mulai_obat);
        $periode_mulai  = $tgl_mulai_obat->copy()->addMonths(intval($bulan_ke) - 1);
        $jml_hari   = 30;
        $periode_akhir  = $periode_mulai->copy()->addDays($jml_hari - 1);

        $obat = PantauanObat::where('uid_keluarga', $request->uid)
                ->whereBetween('tanggal', [$periode_mulai->format('Y-m-d'), $periode_akhir->format('Y-m-d')])
                ->get()->keyBy('tanggal');
        
        if (count($obat) < 1) return send_400('Data log pantauan obat belum ada.');
        
        $heatmap_data = [
            'Mual'      => [],
            'Pipis Merah'   => [],
            'Pendengaran'   => [],
            'Penglihatan'   => [],
            'Pegal'     => [],
            'Batuk'     => [],
            'Demam'     => [],
        ];

        // menghitung hari ke berapa
        $hariKe = null;
        $fasePengobatan = null;
        if ($user->status_tbc == 'Dalam Pengobatan' && $user->tgl_mulai_obat) {
            $tgl_mulai = $tgl_mulai_obat->startOfDay();
            $today = Carbon::now()->startOfDay();

            $hariKe = $tgl_mulai->diffInDays($today) + 1;
            if ($hariKe <= 60) {
                $fasePengobatan = 'Fase Intensif (Bulan 1-2)';
            } else if ($hariKe <= 180) {
                $fasePengobatan = 'Fase Lanjutan (Bulan 3-6)';
            } else {
                $fasePengobatan = 'Masa Pengobatan Standar Selesai (Evaluasi)';
            }

            $obat->transform(function ($log) use ($tgl_mulai) {
                $tgl_log = Carbon::parse($log->tanggal)->startOfDay();
                $log->hari_ke   = $tgl_mulai->diffInDays($tgl_log) + 1;
                $log->bulan_ke  = intval($tgl_mulai->diffInMonths($tgl_log)) + 1;
                $log->translated_date = Carbon::parse($log->tanggal)->locale('id')->translatedFormat('d F Y');

                return $log;
            });
        }

        for ($tgl=0; $tgl < $jml_hari; $tgl++) { 
            // $tgl_key = $bln_awal->copy()->day($tgl)->format('Y-m-d');
            // $label_x = $tgl;
            $hari_ini   = $periode_mulai->copy()->addDays($tgl);
            $tgl_key    = $hari_ini->format('Y-m-d');
            $label_x    = sprintf("%02d", $tgl + 1);

            $tgl_kalender = $hari_ini->locale('id')->translatedFormat('d M Y');

            foreach ($heatmap_data as $gejala => $value) {
                $column_map = [
                    'Mual' => 'efek_mual',
                    'Pipis Merah'   => 'efek_pipis_merah',
                    'Pendengaran'   => 'efek_pendengaran',
                    'Penglihatan'   => 'efek_penglihatan',
                    'Pegal' => 'efek_pegal',
                    'Batuk' => 'efek_batuk',
                    'Demam' => 'efek_demam'
                ];
                $db_column  = $column_map[$gejala];

                if ($obat->has($tgl_key)) {
                    $obat_hari_ini  = $obat->get($tgl_key);
                    $heatmap_data[$gejala][]    = [
                        'x'     => $label_x,
                        'y'     => $obat_hari_ini->$db_column ? 1 : 0,
                        'date'  => $tgl_kalender
                    ];
                } else {
                    $heatmap_data[$gejala][]    = [
                        'x'     => $label_x,
                        'y'     => -1,
                        'date'  => $tgl_kalender
                    ];
                }
            }

            // if ($obat->has($tgl_key)) {
            //     $obat_hari_ini = $obat->get($tgl_key);

            //     $heatmap_data['Mual'][]     = ['x' => $label_x, 'y' => $obat_hari_ini->efek_mual ? 1 : 0];
            //     $heatmap_data['Pipis Merah'][]  = ['x' => $label_x, 'y' => $obat_hari_ini->efek_pipis_merah ? 1 : 0];
            //     $heatmap_data['Pendengaran'][]  = ['x' => $label_x, 'y' => $obat_hari_ini->efek_pendengaran ? 1 : 0];
            //     $heatmap_data['Penglihatan'][]  = ['x' => $label_x, 'y' => $obat_hari_ini->efek_penglihatan ? 1 : 0];
            //     $heatmap_data['Pegal'][]    = ['x' => $label_x, 'y' => $obat_hari_ini->efek_pegal ? 1 : 0];
            //     $heatmap_data['Batuk'][]    = ['x' => $label_x, 'y' => $obat_hari_ini->efek_batuk ? 1 : 0];
            //     $heatmap_data['Demam'][]    = ['x' => $label_x, 'y' => $obat_hari_ini->efek_demam ? 1 : 0];
            // } else {
            //     $heatmap_data['Mual'][]     = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Pipis Merah'][]  = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Pendengaran'][]  = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Penglihatan'][]  = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Pegal'][]    = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Batuk'][]    = ['x' => $label_x, 'y' => -1];
            //     $heatmap_data['Demam'][]    = ['x' => $label_x, 'y' => -1];
            // }
        }

        // Data grafik heatmap
        $series_data = [];
        foreach ($heatmap_data as $gejala => $point) {
            $series_data[] = [
                'name'  => $gejala,
                'data'  => $point,
            ];
        }

        // Ringakasan total
        $summary = [
            'mual'  => $obat->where('efek_mual', true)->count(),
            'pipis' => $obat->where('efek_pipis_merah', true)->count(),
            'pendengaran' => $obat->where('efek_pendengaran', true)->count(),
            'penglihatan' => $obat->where('efek_penglihatan', true)->count(),
            'pegal' => $obat->where('efek_pegal', true)->count(),
            'batuk' => $obat->where('efek_batuk', true)->count(),
            'demam' => $obat->where('efek_demam', true)->count(),
        ];

        return send_200(
            'Detail data ' . $user->nama_lengkap, 
            [
                'pengguna'  => $user,
                'berat'     => ['data' => $data_berat, 'label' => $label_berat],
                'series'    => $series_data,
                'summary'   => $summary,
                'durasi'    => ['bulan_ke' => $last_bulan->bulan_ke ?? 0, 'hari_ke' => $hariKe, 'fase' => $fasePengobatan],
                'riwayat'   => $obat->sortBy('tanggal')->values(),
            ]
        );
    }

    public function heatmap_monthly(Request $request)
    {
        //
    }

    public function ss_obat()
    {
        $request = Request();
        $page   = intval($request->page) < 1 ? 1 : $request->page;
        $size   = $request->size ?? 10;
        $sort   = ($request->filled('sortField') && $request->sortField != 'null') ? $request->sortField : null;
        $order  = $request->sortOrder ?? 'asc';
        $faskes = (isset($request->faskes) && !empty($request->faskes)) ? $request->faskes : null;
        $kec    = (isset($request->kecamatan) && !empty($request->kecamatan)) ? $request->kecamatan : null;
        $total  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.obatTerakhir', 'keluarga.beratTerakhir'])
                ->whereNotNull('jenis_tcm')
                ->whereHas('keluarga', function($q) {
                    $q->whereIn('status_tbc', ['Dalam Pengobatan'])
                      ->whereNull('deleted_at');
                })->count();

        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id,tgl_mulai_obat', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.obatTerakhir', 'keluarga.beratTerakhir']);
        
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
                $q->whereIn('status_tbc', ['Dalam Pengobatan'])
                  ->whereNull('deleted_at');
            })
            ->whereNull('deleted_at');
        $totalFiltered = $query->count();
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

        $data = [];
        foreach ($result as $key => $value) {
            $nik = $request->nik == 'show' ? ($value->keluarga->nik ?? '-') : (!empty($value->keluarga->nik) ? substr($value->keluarga->nik, 0, 4) . str_repeat("*", strlen($value->keluarga->nik) - 4) : '-');
            $data[] = [
                'nik'       => $nik,
                'nama'      => $value->keluarga->nama_lengkap,
                'color'     => $value->color,
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
                'mulai'     => Carbon::parse($value->keluarga->tgl_mulai_obat)->locale('id')->translatedFormat('d F Y'),
                'obat'      => $value->keluarga->obatTerakhir ? Carbon::parse($value->keluarga->obatTerakhir->created_at)->locale('id')->translatedFormat('d F Y') : '-',
                'berat'     => $value->keluarga->beratTerakhir->berat_badan ?? '-',
                'uid'       => $value->uid_sesi,
                'opsi'      => '
                        <span class="inline-flex gap-2.5">
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_detail(`' .$value->uid_keluarga. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Lihat Detail</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-primary" onclick="_verifikasi(`' .$value->uid_sesi. '`, `' .$value->keluarga->nama_lengkap. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-shield-search text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Ubah Status Akhir</span>
                                </span>
                            </a>
                        </span>
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
