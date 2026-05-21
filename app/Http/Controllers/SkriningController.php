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

        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id,deleted_at', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa']);

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
                'opsi'      => '
                        <span class="inline-flex gap-2.5">
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_detail(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Lihat Detail</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-primary" onclick="_reset_status(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil" aria-hidden="true">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                    <path d="m15 5 4 4"></path>
                                </svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Reset Status TBC</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_reset_hasil(`' .$value->uid_sesi. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-disconnect text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Ubah Hasil Skrining</span>
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
