<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DataKeluarga;
use App\Models\Desa;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\StatusKeluarga;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function view_user()
    {
        if (!Auth::user()->hasRole('user')) return abort(404);

        $user = DataKeluarga::with('user:uuid,email')->where('uid_keluarga', Auth::user()->uuid)->whereNull('deleted_at')->first();
        if (!$user) return abort(404);

        $data = [
            'profile'    => $user,
            'faskes'     => Faskes::all(),
            'kecamatan'  => Kecamatan::all(),
            'status'     => StatusKeluarga::all(),
            'desa'       => !empty($user->desakel_id) ? Desa::where('kec_id', $user->kec_id)->get() : [],
        ];

        return view('users.profile', $data);
    }

    public function view_admin()
    {
        if (!Auth::user()->hasAnyRole(['faskes', 'admin', 'superadmin'])) return abort(404);

        $data = [
            'profile'   => Auth::user(),
            'images'    => (file_exists(public_path('storage/profile/' . Auth::user()->uuid) . '.png') ? (asset('storage/profile/' . Auth::user()->uuid) . '.png') : null)
        ];

        return view('profile.admin', $data);
    }

    public function save_user_profile(Request $request)
    {
        if (!Auth::user()->hasRole('user')) return abort(404);
        $userId = $request->user()?->id;
        $request->validate([
            'nama'      => ['required', 'string', 'max:50'],
            'dob'       => ['required', 'date'],
            'alamat'    => ['required', 'string'],
            'kecamatan' => ['required', 'numeric', 'exists:kecamatans,kec_id'],
            'desa'      => ['required', 'numeric', 'exists:desas,desakel_id'],
            'jenkel'    => ['required', 'string', 'in:L,P'],
            'status'    => ['required', 'string', 'max:50'],
            'telepon'   => ['required', 'numeric', 'starts_with:628', 'digits_between:9,14'],
            'faskes'    => ['required', 'string', 'exists:faskes,faskes_id'],
            // 'nik'       => ['required', 'numeric', 'digits:16', 'unique:data_keluargas,nik'],
            'email'     => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
        ]);

        if (!empty($request->telepon) && !str_starts_with($request->telepon, '628')) {
            // return send_400('Format nomor telepon tidak sesuai. Mohon menggunakan awalan 628xxx');
            return back()->with('error', 'Format nomor telepon tidak sesuai. Mohon menggunakan awalan 628xxx');
        }
        if (!empty($request->email)) {
            if (User::where('email', $request->email)->where('id', '!=', $request->user()->id)->exists()) return back()->with('error', 'Alamat email sudah digunakan');
        }

        $data = [
            'nama_lengkap'  => $request->nama,
            'alamat_nik'    => $request->alamat,
            'tgl_lahir'     => $request->dob,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'jenkel'        => $request->jenkel,
            'status_keluarga' => $request->status,
            'kec_id'        => $request->kecamatan,
            'desakel_id'    => $request->desa,
            'id_faskes'     => $request->faskes,
        ];
        $update = DataKeluarga::where('uid_keluarga', $request->user()->uuid)->where('is_auth', 1)->update($data);
        if (!$update) return back()->with('error', 'Gagal memperbarui biodata');

        User::where('uuid', $request->user()->uuid)->update(['name' => $request->nama, 'email' => ($request->email ?? $request->user()?->email)]);

        return redirect()->back()->with('success', 'Berhasil memperbarui biodata');
    }

    public function save_admin_profile(Request $request)
    {
        $userId = $request->user()->id;
        $uuid = $request->user()->uuid;
        $request->validate([
            'nama'      => 'required|string|max:50',
            'email'     => "nullable|email|unique:users,email,$userId",
            'gambar'    => 'nullable|file|mimes:png,jpg,jpeg|max:4096',
            'password'  => 'sometimes|nullable|confirmed|string|min:8|max:50',
            'password_confirmation' => 'sometimes|nullable|string'
        ]);

        if (!empty($request->password) && ($request->password != $request->password_confirmation)) return back()->with('error', 'Password tidak sama.');
        if (!empty($request->file('gambar'))) {
            // Log::info('file exists');
            upload_profile($request->file('gambar'), $uuid);
        }

        $upd = User::where('uuid', $uuid)->update(['name' => $request->nama, 'email' => $request->email]);
        if (!$upd) return back()->with('error', 'Gagal memperbarui profile');

        if (!empty($request->password) && ($request->password == $request->password_confirmation)) {
            $pass = User::where('uuid', $uuid)->update(['password' => Hash::make($request->password)]);
            if ($pass) {
                DB::table('sessions')->where('user_id', $userId)->delete();
            }
        }

        return redirect()->back()->with('success', 'Berhasil memperbarui data profile.');
    }
}
