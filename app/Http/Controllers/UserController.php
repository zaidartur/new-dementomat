<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pengguna()
    {
        $data = [
            'lists' => User::where('level', 'user')->get(),
        ];

        return view('users.pengguna', $data);
    }

    public function update_user_mobile(Request $request)
    {
        //
    }

    public function update_user_username(Request $request)
    {
        $request->validate([
            'username'  => 'required|string'
        ]);

        $find = User::where('username', $request->username)->first();
        if ($find) {
            return response()->json([
                'username'  => 'Username sudah digunakan'
            ], 400);
        }

        $user = User::where('uuid', $request->user()->uuid)->update(['username', $request->username]);
        if (!$user) {
            return response()->json([
                'username'  => 'Username gagal diubah'
            ], 400);
        }

        return response()->json([
            'username'  => 'Username berhasil diubah'
        ], 201);
    }
}
