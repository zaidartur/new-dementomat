<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class MobileController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik'           => 'required|numeric|max_digits:16|min_digits:15',
            'password'      => 'required|min:6',
            'device_name'   => 'required|string',
        ]);
    
        $detail = DataKeluarga::where('nik', $request->nik)->where('is_auth', 1)->whereNull('parent_user')->first();
        if (!$detail) {
            // throw ValidationException::withMessages([
            //     'nik' => ['NIK tidak terdata pada database.'],
            // ]);
            return send_400('NIK tidak terdata pada database.');
        }

        $user = User::where('uuid', $detail->uid_keluarga)->whereNull('deleted_at')->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'nik' => ['Kredensial yang diberikan tidak sesuai.'],
            // ]);
            return send_400('Kredensial yang diberikan tidak sesuai.');
        }
    
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        // 1. Validate the input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nik'   => 'numeric|min_digits:15|max_digits:16',
            'password' => ['required', 'confirmed', Password::defaults()],
            'device_name' => 'required|string',
        ]);

        $detail = DataKeluarga::where('nik', $request->nik)->first();
        if ($detail) {
            // throw ValidationException::withMessages([
            //     'nik' => ['NIK sudah terdata pada database. Cobalah untuk login.'],
            // ]);
            send_400('NIK sudah terdata pada database. Cobalah untuk login.');
        }

        $username = $this->generateUniqueUsername($request->nama);
        $uuid = Str::uuid();

        // 2. Create the user
        $user = User::create([
            'uuid'      => $uuid,
            'username'  => $username,
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'level'     => 'user',
        ]);

        if (!$user) {
            User::where('uuid', $uuid)->delete();
            // throw ValidationException::withMessages([
            //     'name' => ['Gagal menyimpan data registrasi, cobalah untuk membuat ulang.'],
            // ]);
            send_400('Gagal menyimpan data registrasi, cobalah untuk membuat ulang.');
        }

        DataKeluarga::create([
            'uid_keluarga'  => $uuid,
            'is_auth'       => 1,
            'nik'           => $request->nik,
            'nama_lengkap'  => $request->nama,
        ]);
        
        $user->assignRole('user');

        // 3. Create the Sanctum token
        $token = $user->createToken($request->device_name)->plainTextToken;

        // 4. Return the user and token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
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

    public function ubah_password(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|string',
            'password'      => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('uuid', $request->user()->uuid)->first();
    
        if (! $user || ! Hash::check($request->password_lama, $user->password)) {
            throw ValidationException::withMessages([
                'password_lama' => ['Password lama yang diberikan tidak sesuai.'],
            ]);
        }

        $upd = User::where('uuid', $request->user()->uuid)->update(['password' => Hash::make($request->password)]);
        if (!$user) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal memperbarui password.'
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Password berhasil diperbarui.'
        ], 200);
    }

    public function deactivate(Request $request)
    {
        $user = User::where('uuid', $request->user()->uuid)->first();
        if (!$user) return send_400('User akun tidak sesuai.');

        $user->deleted_at = date('Y-m-d H:i:s');
        $upd = $user->save();
        if (!$upd) return send_400('Gagal deaktivasi akun.');

        // eliminate all user session ID in PAN
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        return send_200('Akun berhasil deaktivasi.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Successfully logged out'
        ], 200);
    }
}
