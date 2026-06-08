<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DataKeluarga;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $data = [
            'kecs'   => Kecamatan::all(),
            'faskes' => Faskes::all(),
        ];
        return view('auth.register_user', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
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
            'nik'       => ['required', 'numeric', 'digits_between:15,16', 'unique:data_keluargas,nik'],
            'email'     => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $uuid = Str::uuid();
        $name = $this->generateUniqueUsername($request->nama);
        $user = User::create([
            'uuid'      => $uuid,
            'username'  => $name,
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'level'     => 'user'
        ]);

        if (!$user) return redirect()->back()->with('error', 'Gagal menyimpan akun pengguna.');

        DataKeluarga::create([
            'uid_keluarga'  => $uuid,
            'is_auth'       => 1,
            'nik'           => $request->nik,
            'nama_lengkap'  => $request->nama,
            'alamat'        => $request->alamat,
            'alamat_nik'    => $request->alamat,
            'tgl_lahir'     => Carbon::parse($request->bod)->format('Y-m-d'),
            'jenkel'        => $request->jenkel,
            'telepon'       => $request->telepon,
            'status_keluarga' => $request->status,
            'kec_id'        => $request->kecamatan,
            'desakel_id'    => $request->desa,
            'id_faskes'     => $request->faskes,
        ]);

        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function generateUniqueUsername($name)
    {
        // Clean the name (remove spaces) and add a random 4-digit number
        // Example: "John Doe" becomes "johndoe_4829"
        $base = Str::slug($name, '');
        $username = $base . '_' . rand(1000, 9999);

        // Check for collisions (ensure it's actually unique)
        while (User::where('username', $username)->exists()) {
            $username = $base . '_' . rand(1000, 9999);
        }

        return $username;
    }
}
