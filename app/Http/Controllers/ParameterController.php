<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriSkrining;
use App\Models\MasterParameterSkrining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    public function view()
    {
        $data = [
            'params'     => MasterParameterSkrining::with('category')->get(),
            'categories' => MasterKategoriSkrining::all(),
        ];

        return view('settings.parameter', $data);
    }

    public function save_param(Request $request)
    {
        $request->validate([
            'kategori'      => 'required|numeric|exists:master_kategori_skrinings,id',
            'kode'          => 'required|string|max:10',
            'pertanyaan'    => 'required|string|min:5',
        ]);

        $save = MasterParameterSkrining::create([
            'uid_parameter'     => Str::uuid(),
            'kategori_id'       => $request->kategori,
            'kode'              => $request->kode,
            'pertanyaan'        => $request->pertanyaan,
        ]);

        if ($save) {
            return redirect()->back()->with('success', 'Berhasil menambahkan parameter.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan parameter.');
        }
    }

    public function update_param(Request $request)
    {
        $request->validate([
            'uid'           => 'required|string|exists:master_parameter_skrinings,uid_parameter',
            'kategori'      => 'required|numeric|exists:master_kategori_skrinings,id',
            'kode'          => 'required|string|max:10',
            'pertanyaan'    => 'required|string|min:5',
        ]);

        $find = MasterParameterSkrining::where('uid_parameter', $request->uid)->first();
        if (!$find) return redirect()->back()->with('error', 'ID Parameter tidak terdaftar.');

        $upd = $find->update([
            'kategori_id'       => $request->kategori,
            'kode'              => $request->kode,
            'pertanyaan'        => $request->pertanyaan,
        ]);

        if ($upd) {
            return redirect()->back()->with('success', 'Berhasil mengubah parameter.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah parameter.');
        }
    }

    public function drop_param(Request $request)
    {
        $request->validate([
            'uid'           => 'required|string|exists:master_parameter_skrinings,uid_parameter',
        ]);

        $find = MasterParameterSkrining::where('uid_parameter', $request->uid)->first();
        if (!$find) return send_400('ID Parameter tidak terdaftar.');

        $del = MasterParameterSkrining::where('uid_parameter', $request->uid)->delete();
        if (!$del) return send_400('Gagal menghapus parameter.');

        return send_200('Berhasil menghapus parameter.');
    }

    public function update_kategori(Request $request)
    {
        $request->validate([
            'uid'   => 'required|numeric|exists:master_kategori_skrinings,id',
            'nama'  => 'required|string|min:10|max:150',
            'min'   => 'required|numeric|min:0',
            'max'   => 'required|numeric|max:130'
        ]);

        $find = MasterKategoriSkrining::where('id', $request->uid)->first();
        if (!$find) return send_400('ID Kategori tidak terdaftar.');

        $upd = $find->update([
            'nama_kategori' => $request->nama,
            'min_age'       => $request->min,
            'max_age'       => $request->max,
        ]);

        if (!$upd) return send_400('Gagal memperbarui kategori.');

        return send_200('Berhasil memperbarui kategori.');
    }

    public function ss_param()
    {
        $request = Request();
        $page   = intval($request->page) < 1 ? 1 : $request->page;
        $size   = $request->size ?? 10;
        $skip   = (intval($page) - 1) * intval($size);
        $sort   = ($request->filled('sortField') && $request->sortField != 'null') ? $request->sortField : null;
        $order  = $request->sortOrder ?? 'asc';
        $jenis  = (isset($request->kategori) && !empty($request->kategori)) ? $request->kategori : null;
        $total  = MasterParameterSkrining::count();

        $query  = MasterParameterSkrining::with('category')->orderBy('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('pertanyaan', 'like', "%$search%")->orWhereHas('category', function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%$search%");
            });
        }
        if (!empty($jenis) && $jenis == 'dewasa') {
            $query->where('kategori_id', 2);
        }
        if (!empty($jenis) && $jenis == 'anak') {
            $query->where('kategori_id', 1);
        }

        $totalFiltered = $query->count();
        $query->skip($skip)->take(intval($size));
        $totals = $query->get();

        $data = [];
        foreach ($totals as $key => $value) {
            $data[] = [
                'uid'       => $value->uid_parameter,
                'jenis_id'  => $value->category->id,
                'jenis'     => $value->category->nama_kategori,
                'text'      => $value->pertanyaan,
                'kode'      => $value->kode,
                'tanggal'   => Carbon::parse($value->updated_at)->locale('id')->translatedFormat('d F Y'),
                'opsi'      => '
                            <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-ghost" onclick="_edit(`'. base64_encode(json_encode($value)) .'`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-message-edit text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Edit Parameter</span>
                                </span>
                            </button>
                            <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_drop(`'. $value->uid_parameter .'`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <i class="ki-filled ki-trash-square text-lg"></i>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Hapus Parameter</span>
                                </span>
                            </button>
                '
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
