<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Profile;
use App\Models\Slider;
use App\Models\User;
use App\Models\Youtube;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UtilityController extends Controller
{
    public function view_profile()
    {
        $session = [];
        if (Auth::user()->hasRole('admin')) {
            $users = User::select('id')->whereIn('level', ['admin', 'faskes', 'user'])->get();
            $lists = [];
            foreach ($users as $key => $value) {
                $lists[] = $value->id;
            }
            $session = DB::table('sessions AS s')
                        ->leftJoin('users AS u', 'u.id', '=', 's.user_id')
                        ->select('s.user_id', 's.ip_address', 's.user_agent', 's.last_activity', 'u.name', 'u.email', 'u.level')
                        ->whereIn('user_id', $lists)->get();
        } elseif (Auth::user()->hasRole('superadmin')) {
            $session = DB::table('sessions AS s')
                        ->leftJoin('users AS u', 'u.id', '=', 's.user_id')
                        ->select('s.user_id', 's.ip_address', 's.user_agent', 's.last_activity', 'u.name', 'u.email', 'u.level')
                        ->get();
        }

        $data = [
            'profile'  => Profile::orderBy('id')->first(),
            'lists'    => $session,
        ];
        
        return view('utility.profile', $data);
    }

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

    public function update_profile(Request $request)
    {
        $request->validate([
            'uid'        => 'required|numeric|exists:profiles,id',
            'nama'       => 'required|string|max:100',
            'deskripsi'  => 'required|string|max:200',
            'alamat'     => 'required|string',
            'telepon'    => 'nullable|numeric|starts_with:62',
            'email'      => 'nullable|email|max:50',
            'website'    => 'nullable|url|max:150',
            'gambar'     => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $find = Profile::where('id', $request->uid)->firstOrFail();

        $location = public_path('storage/logo/' . $find->logo);

        if (!empty($request->file('gambar'))) {
            $file  = $request->file('gambar');
            $image = upload_logo($file);
            if (!$image) {
                $image = $find->logo;
            } else {
                if (file_exists($location)) unlink($location);
            }
        } else {
            $image = $find->logo;
        }

        $upd = $find->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'email'     => $request->email,
            'website'   => $request->website,
            'logo'      => $image
        ]);
        if (!$upd) return redirect()->back()->with('error', 'Gagal memperbarui data profile.');

        // redirect back with clear cache
        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->with('success', 'Berhasil memperbarui data profile.');
    }

    public function show_image($uid)
    {
        try {
            $id  = Crypt::decryptString($uid);
            if (!$id) return abort(404);

            $img = Slider::where('slider_id', $id)->firstOrFail();
            if (!$img) return abort(404);

            $location = public_path('storage/slider/' . $img->foto_slider);
            if (!file_exists($location)) return abort(404);

            return response()->file($location);
        } catch (Exception $e) {
            // return response()->json($e);
            return abort(404);
        }
    }

    public function show_logo()
    {
        $default = public_path('assets/images/logos.png');
        try {
            $profile = Profile::orderBy('id')->firstOrFail();
            if (!$profile || empty($profile->logo)) return response()->file($default);

            $location = public_path('storage/logo/' . $profile->logo);
            // Log::info('location', [$location]);
            if (!file_exists($location)) return response()->file($default);

            return response()->file($location);
        } catch (Exception $e) {
            // return response()->json($e);
            return response()->file($default);
        }
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
