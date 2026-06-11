<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Desa;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\Kontak;
use App\Models\Slider;
use App\Models\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MobileUtilityController extends Controller
{
    public function data_faskes()
    {
        $faskes = Faskes::select('faskes_id', 'nama_faskes', 'alamat_faskes')->get();
        if (!$faskes) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal mengakses data faskes.',
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Daftar faskes di kabupaten Karanganyar.',
            'data'      => $faskes,
        ], 200);
    }

    public function data_kecamatan()
    {
        $kec = Kecamatan::select('kec_id', 'kec_name')->get();
        if (!$kec) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal mengakses data kecamatan.',
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Daftar kecamatan di kabupaten Karanganyar.',
            'data'      => $kec,
        ], 200);
    }

    public function data_desa()
    {
        $desa = Desa::with('kecamatan')->get();
        if (!$desa) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal mengakses data desa.',
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Daftar desa di kabupaten Karanganyar.',
            'data'      => $desa,
        ], 200);
    }

    public function data_desa_by_kecamatan($kec)
    {
        // validasi kecamatan
        $lists = Kecamatan::select('kec_id')->get();
        $kecId = [];
        foreach ($lists as $value) {
            $kecId[] = $value->kec_id;
        }
        if (intval($kec) == 0 || !in_array(intval($kec), $kecId)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'ID kecamatan tidak diketahui.',
            ], 400);
        }

        $desa = Desa::with('kecamatan')->select('desakel_id', 'kec_id', 'desakel_name')->where('kec_id', intval($kec))->get();
        if (!$desa) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal mengakses data desa.',
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Daftar desa di kecamatan '. $desa[0]->kecamatan->kec_name .'.',
            'data'      => $desa,
        ], 200);
    }

    public function data_kontak()
    {
        $res = Kontak::where('jenis_kontak', 'admin')->first();
        return send_200('Data kontak admin.', $res);
    }

    public function data_youtube()
    {
        $lists = Youtube::where('status', 'active')->get();

        return send_200('Daftar video', $lists);
    }

    public function data_slider()
    {
        $lists = Slider::where('status', 'active')->get()->makeHidden(['id', 'foto_slider']);
        $slide = $lists->collect($lists)->map(function($ls) {
            $encUid     = Crypt::encryptString($ls->slider_id);
            $imageUrl   = route('slider.url', $encUid);
            $ls->image_url = $imageUrl;

            return $ls;
        });

        // return send_200('Data slider', $slide);
        return response()->json([
            'message'   => 'Data slider',
            'data'      => $slide,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function data_berita()
    {
        $lists = Berita::where('status', 'active')->get();

        return send_200('Data berita', $lists);
    }
}
