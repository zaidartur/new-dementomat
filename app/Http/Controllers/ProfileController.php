<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DataKeluarga;
use App\Models\Desa;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function view_user()
    {
        $user = DataKeluarga::with('user:uuid,email')->where('uid_keluarga', Auth::user()->uuid)->whereNull('deleted_at')->first();
        if (!$user) return abort(404);
        if (!Auth::user()->hasRole('user')) return abort(404);

        $data = [
            'profile'    => $user,
            'faskes'     => Faskes::all(),
            'kecamatan'  => Kecamatan::all(),
            'desa'       => !empty($user->desakel_id) ? Desa::where('kec_id', $user->kec_id)->get() : [],
        ];

        return view('users.profile', $data);
    }

    public function save_user_profile(Request $request)
    {
        if (!Auth::user()->hasRole('user')) return abort(404);
        $request->validate([
            'nama'      => ['required', 'string', 'max:50'],
            'bod'       => ['required', 'date'],
            'alamat'    => ['required', 'string'],
            'kecamatan' => ['required', 'numeric', 'exists:kecamatans,kec_id'],
            'desa'      => ['required', 'numeric', 'exists:desas,desakel_id'],
            'jenkel'    => ['required', 'string', 'in:L,P'],
            'status'    => ['required', 'string', 'max:50'],
            'telepon'   => ['required', 'numeric', 'starts_with:628', 'digits_between:9,14'],
            'faskes'    => ['required', 'string', 'exists:faskes,faskes_id'],
            // 'nik'       => ['required', 'numeric', 'digits:16', 'unique:data_keluargas,nik'],
            'email'     => ['nullable', 'string', 'lowercase', 'email', 'max:100', 'unique:'.User::class],
        ]);
    }
}
