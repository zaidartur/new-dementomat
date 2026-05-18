<?php

namespace App\Http\Controllers;

use App\Models\DataSesiSkrining;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function ss_skrining()
    {
        $request = new Request();
        $page   = $request->page;
        $size   = $request->size;
        $faskes = (isset($request->faskes) && !empty($request->faskes)) ? $request->faskes : null;
        $kec    = (isset($request->kecamatan) && !empty($request->kecamatan)) ? $request->kecamatan : null;
        $total  = DataSesiSkrining::orderBy('created_at')->count();

        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nama_lengkap,status_keluarga,status_tbc,id_faskes', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak']);

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

        $totalFiltered = $query->count();
        $query->orderBy('created_at', 'desc');
        $query->skip(intval($page)-1)->take(intval($size));
        $totals = $query->get();
        $data   = [];
        foreach ($totals as $key => $value) {
            //
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
