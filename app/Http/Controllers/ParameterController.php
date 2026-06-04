<?php

namespace App\Http\Controllers;

use App\Models\DataRuleKondisi;
use App\Models\DataRuleSkrining;
use App\Models\MasterKategoriSkrining;
use App\Models\MasterParameterSkrining;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    public function view()
    {
        $data = [
            'params'     => MasterParameterSkrining::with('category')->get(),
            'categories' => MasterKategoriSkrining::all(),
            'rules'      => DataRuleSkrining::with(['rule_kondisi', 'rule_kondisi.parameter', 'categories'])->get(),
        ];

        return view('settings.parameter', $data);
    }

    public function detail_param(Request $request)
    {
        $request->validate([
            'uid'   => 'required|integer|exists:master_kategori_skrinings,id'
        ]);

        $find = MasterParameterSkrining::where('kategori_id', $request->uid)->get();
        if (!$find) return send_400('Data parameter tidak ditemukan.');

        return send_200('Daftar parameter', $find);
    }

    public function save_param(Request $request)
    {
        $request->validate([
            'kategori'      => 'required|numeric|exists:master_kategori_skrinings,id',
            'kode'          => 'required|string|max:10',
            'judul'         => 'required|string|min:5',
        ]);

        $save = MasterParameterSkrining::create([
            'uid_parameter'     => Str::uuid(),
            'kategori_id'       => $request->kategori,
            'kode'              => $request->kode,
            'pertanyaan'        => $request->judul,
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
            'judul'         => 'required|string|min:5',
        ]);

        $find = MasterParameterSkrining::where('uid_parameter', $request->uid)->first();
        if (!$find) return redirect()->back()->with('error', 'ID Parameter tidak terdaftar.');

        $upd = $find->update([
            'kategori_id'       => $request->kategori,
            'kode'              => $request->kode,
            'pertanyaan'        => $request->judul,
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

    public function save_rule(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:150',
            'kategori'  => 'required|numeric|exists:master_kategori_skrinings,id',
            'rekom'     => 'required|string|min:10',
            'parameter' => 'required|array',
        ]);

        $uuid = Str::uuid();
        $rule = DataRuleSkrining::create([
            'uid_rule'      => $uuid,
            'kategori_id'   => $request->kategori,
            'nama_aturan'   => $request->nama,
            'rekomendasi'   => $request->rekom,
        ]);
        if (!$rule) return send_400('Gagal menyimpan data rule.');

        foreach ($request->parameter as $key => $value) {
            DataRuleKondisi::create([
                'rule_uid'      => $uuid,
                'parameter_uid' => $value,
            ]);
        }

        return send_201('Data rule berhasil di simpan.');
    }

    public function update_rule(Request $request)
    {
        $request->validate([
            'uid'       => 'required|string|exists:data_rule_skrinings,uid_rule',
            'nama'      => 'required|string|max:150',
            'kategori'  => 'required|numeric|exists:master_kategori_skrinings,id',
            'rekom'     => 'required|string|min:10',
            'parameter' => 'required|array',
        ]);

        $rule = DataRuleSkrining::where('uid_rule', $request->uid)->first();
        if (!$rule) return send_400('ID rule tidak terdaftar.');

        $rule->update([
            'kategori_id'   => $request->kategori,
            'nama_aturan'   => $request->nama,
            'rekomendasi'   => $request->rekom,
        ]);

        // reset tabel kondisi
        DataRuleKondisi::where('rule_uid', $request->uid)->delete();
        
        foreach ($request->parameter as $key => $value) {
            DataRuleKondisi::create([
                'rule_uid'      => $request->uid,
                'parameter_uid' => $value,
            ]);
        }

        return send_200('Data rule berhasil diperbarui.');
    }

    public function drop_rule(Request $request)
    {
        $request->validate([
            'uid'       => 'required|string',
        ]);

        try {
            $id   = Crypt::decryptString($request->uid);
            Log::info($id);
            $rule = DataRuleSkrining::where('uid_rule', $id)->first();
            if (!$rule) return send_400('ID rule tidak terdaftar.');

            $drop = DataRuleKondisi::where('rule_uid', $id)->delete();
            if (!$drop) return send_400('Gagal menghapus data rule.');

            DataRuleSkrining::where('uid_rule', $id)->delete();

            return send_200('Data rule berhasil dihapus.');
        } catch (Exception $e) {
            return send_400('Gagal menghapus data regulasi skrining.');
        }
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
