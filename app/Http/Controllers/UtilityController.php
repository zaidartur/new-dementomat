<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Slider;
use App\Models\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UtilityController extends Controller
{
    public function view_youtube()
    {
        $data = [
            'list'  => Youtube::all(),
        ];
        
        return view('utility.youtube', $data);
    }

    public function view_slider()
    {
        $data = [
            'list'  => Slider::all(),
        ];

        return view('utility.slider', $data);
    }

    public function view_berita()
    {
        $data = [
            'list'  => Berita::all(),
        ];

        return view('utility.berita', $data);
    }

    public function save_slider(Request $request)
    {
        $request->validate([
            'gambar'     => 'required|file|mimes:jpg,jpeg,png|max:3072',
            'keterangan' => 'nullable|string|max:150',
        ]);

        $file  = $request->file('gambar');
        $extension = $file->getClientOriginalExtension();
        $uuid  = Str::uuid();
        $image = upload_slider($file, $uuid);

        if (!$image) return send_400('Gagal mengunggah gambar.');

        $save = Slider::create([
            'slider_id'     => $uuid,
            'foto_slider'   => $image,
            'keterangan'    => $request->keterangan,
            'status'        => $request->filled('status') ? 'active' : 'inactive',
        ]);

        if (!$save) return send_400('Gagal menyimpan data slider.');

        return send_201('Data slider berhasil diunggah.');
    }

    public function update_slider(Request $request)
    {
        $request->validate([
            'gambar'     => 'nullable|file|mimes:jpg,jpeg,png|max:3072',
            'keterangan' => 'nullable|string|max:150',
            'uid'        => 'required|string|exists:sliders,slider_id',
        ]);

        $find = Slider::where('slider_id', $request->uid)->firstOrFail();
        // if (!$find) return send_400('ID tidak diketahui.');

        $location = public_path('storage/slider/' . $find->foto_slider);

        if (!empty($request->file('gambar'))) {
            $file  = $request->file('gambar');
            $image = upload_slider($file, $find->slider_id);
            if (!$image) {
                $image = $find->foto_slider;
            } else {
                if (file_exists($location)) unlink($location);
            }
        } else {
            $image = $find->foto_slider;
        }

        $upd = $find->update([
            'foto_slider'   => $image,
            'keterangan'    => $request->keterangan,
            'status'        => $request->filled('status') ? 'active' : 'inactive',
            ]);
        if (!$upd) return send_400('Gagal memperbarui gambar.');

        return send_200('Berhasil memperbarui data.');
    }

    public function hapus_slider(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|exists:sliders,slider_id'
        ]);

        $find = Slider::where('slider_id', $request->uid)->firstOrFail();

        $del = Slider::where('slider_id', $request->uid)->delete();
        if (!$del) return send_400('Gagal menghapus data gambar.');

        return send_200('Berhasil menghapus data gambar.');
    }

    public function show_image($uid)
    {
        $id  = Crypt::decryptString($uid);
        if (!$id) return send_400('ID tidak ditemukan.');

        $img = Slider::where('slider_id', $id)->firstOrFail();
        if (!$img) return abort(404);

        $location = public_path('storage/slider/' . $img->foto_slider);
        if (!file_exists($location)) return abort(404);

        return response()->file($location);
    }

    public function save_video(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:150',
            'video'     => 'required|url|starts_with:https://'
        ]);

        $save = Youtube::create([
            'judul'         => $request->judul,
            'embed_link'    => $request->video,
            'status'        => $request->filled('status') ? 'active' : 'inactive',
        ]);

        if (!$save) return send_400('Gagal menyimpan URL video.');

        return send_201('Berhasil menyimpan URL video.');
    }

    public function update_video(Request $request)
    {
        $request->validate([
            'uid'       => 'required|numeric|exists:youtubes,id',
            'judul'     => 'required|string|max:150',
            'video'     => 'required|url|starts_with:https://'
        ]);

        $find = Youtube::findOrFail($request->uid);
        $save = $find->update([
            'judul'         => $request->judul,
            'embed_link'    => $request->video,
            'status'        => $request->filled('status') ? 'active' : 'inactive',
        ]);

        if (!$save) return send_400('Gagal memperbarui URL video.');

        return send_201('Berhasil memperbarui URL video.');
    }

    public function hapus_video(Request $request)
    {
        $request->validate([
            'uid'   => 'required|numeric|exists:youtubes,id'
        ]);

        $find = Youtube::findOrFail($request->uid);
        $del = $find->delete();

        if (!$del) return send_400('Gagal menghapus data video.');

        return send_200('Berhasil menghapus video.');
    }
}
