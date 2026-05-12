<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Http\Request;
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
    
        $detail = DetailUser::where('nik', $request->nik)->first();
        if (!$detail) {
            throw ValidationException::withMessages([
                'nik' => ['NIK tidak terdata pada database.'],
            ]);
        }

        $user = User::where('uuid', $detail->uuid_user)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'nik' => ['Kredensial yang diberikan tidak sesuai.'],
            ]);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nik'   => 'numeric|min_digits:15|max_digits:16',
            'password' => ['required', 'confirmed', Password::defaults()],
            'device_name' => 'required|string',
        ]);

        $detail = DetailUser::where('nik', $request->nik)->first();
        if ($detail) {
            throw ValidationException::withMessages([
                'nik' => ['NIK sudah terdata pada database. Cobalah untuk login.'],
            ]);
        }

        $username = $this->generateUniqueUsername($request->name);
        $uuid = Str::uuid();

        // 2. Create the user
        $user = User::create([
            'uuid'      => $uuid,
            'username'  => $username,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'level'     => 'user',
        ]);

        if (!$user) {
            throw ValidationException::withMessages([
                'name' => ['Gagal menyimpan data registrasi, cobalah untuk membuat ulang.'],
            ]);
        }
        $user->assignRole('user');

        DetailUser::create([
            'uuid_user' => $uuid,
            'nik'       => $request->nik,
        ]);

        // 3. Create the Sanctum token
        $token = $user->createToken($request->device_name)->plainTextToken;

        // 4. Return the user and token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201); // 201 Created
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
