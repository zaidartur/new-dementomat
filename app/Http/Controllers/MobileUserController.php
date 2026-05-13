<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MobileUserController extends Controller
{
    public function profile()
    {
        $request = Request();
        $users = User::with(['detail', 'detail.kecamatan', 'detail.desa', 'detail.faskes', 'detail.faskes.kecamatan', 'detail.faskes.desa'])
                ->where('uuid', $request->user()->uuid)
                ->first()
                ->makeHidden('level');
        if (!$users) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal menampilkan data profile.'
            ], 400);
        }

        $usia  = !empty($users->detail->tgl_lahir) ? Carbon::parse($users->detail->tgl_lahir)->age : null;
        $users->detail->usia = $usia;

        return response()->json($users, 200);
    }

    public function keluarga()
    {
        $request = Request();
        $users = User::with(['detail', 'keluarga', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.faskes', 'keluarga.faskes.kecamatan', 'keluarga.faskes.desa'])
                ->where('uuid', $request->user()->uuid)
                ->first()
                ->makeHidden('level');
        if (!$users) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal menampilkan data keluarga.'
            ], 400);
        }

        $usia  = !empty($users->detail->tgl_lahir) ? Carbon::parse($users->detail->tgl_lahir)->age : null;
        $users->detail->usia = $usia;
        if (count($users->keluarga) > 0) {
            foreach ($users->keluarga as $key => $value) {
                $umur = !empty($value->tgl_lahir) ? Carbon::parse($value->tgl_lahir)->age : null;
                $value->usia = $umur;
            }
        }

        return response()->json($users, 200);
    }

    public function update_username(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|min:5'
        ]);

        $find = User::where('username', $request->username)->first();
        if ($find) {
            return response()->json([
                'username'  => 'Username sudah digunakan.'
            ], 400);
        }

        $user = User::where('uuid', $request->user()->uuid)->update(['username' => $request->username]);
        if (!$user) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Username gagal diubah.'
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Username berhasil diubah.'
        ], 200);
    }

    public function update_biodata(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string',
            'alamat_nik'=> 'required|string',
            'dob'       => 'required|date',
            'jenkel'    => 'required|string|max:2',
            'alamat'    => 'required|string',
            'telepon'   => 'required|numeric',
            'kecamatan' => 'required|numeric',
            'desa'      => 'required|numeric',
            'faskes'    => 'required|string|min:35|max:36',
        ]);

        $data = [
            'nama_lengkap'  => $request->nama,
            'alamat_nik'    => $request->alamat_nik,
            'tgl_lahir'     => $request->dob,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'jenkel'        => $request->jenkel,
            'kec_id'        => $request->kecamatan,
            'desakel_id'    => $request->desa,
            'id_faskes'     => $request->faskes,
        ];
        $update = DataKeluarga::where('uid_keluarga', $request->user()->uuid)->where('is_auth', 1)->update($data);
        if (!$update) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal memperbarui biodata.'
            ], 400);
        }

        User::where('uuid', $request->user()->uuid)->update(['name' => $request->nama]);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Berhasil memperbarui biodata.'
        ], 200);
    }

    public function tambah_keluarga(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string',
            'nik'       => 'required|numeric|min_digits:15|max_digits:16',
            'alamat_nik'=> 'required|string',
            'dob'       => 'required|date',
            'jenkel'    => 'required|string|max:2',
            'status'    => 'nullable|string',
            'alamat'    => 'required|string',
            'telepon'   => 'nullable|numeric|max_digits:16|min_digits:10',
            'kecamatan' => 'required|numeric',
            'desa'      => 'required|numeric',
            'faskes'    => 'required|string|min:35|max:36',
        ]);

        $data = [
            'uid_keluarga'  => Str::uuid(),
            'parent_user'   => $request->user()->uuid,
            'is_auth'       => 0,
            'nik'           => $request->nik,
            'nama_lengkap'  => $request->nama,
            'alamat_nik'    => $request->alamat_nik,
            'tgl_lahir'     => $request->dob,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'jenkel'        => $request->jenkel,
            'status_keluarga' => $request->status,
            'kec_id'        => $request->kecamatan,
            'desakel_id'    => $request->desa,
            'id_faskes'     => $request->faskes,
        ];
        $save = DataKeluarga::create($data);
        if (!$save) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal menambah data keluarga.'
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Berhasil menambah data keluarga.'
        ], 200);
    }

    public function update_keluarga(Request $request)
    {
        $request->validate([
            'uid'       => 'required|string|min:35|max:36',
            'nama'      => 'required|string',
            'alamat_nik'=> 'required|string',
            'dob'       => 'required|date',
            'jenkel'    => 'required|string|max:2',
            'status'    => 'nullable|string',
            'alamat'    => 'required|string',
            'telepon'   => 'required|numeric|min_digits:10|max_digits:16',
            'kecamatan' => 'required|numeric',
            'desa'      => 'required|numeric',
            'faskes'    => 'required|string|min:35|max:36',
        ]);

        $data = [
            'nama_lengkap'  => $request->nama,
            'alamat_nik'    => $request->alamat_nik,
            'tgl_lahir'     => $request->dob,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'jenkel'        => $request->jenkel,
            'status_keluarga' => $request->status,
            'kec_id'        => $request->kecamatan,
            'desakel_id'    => $request->desa,
            'id_faskes'     => $request->faskes,
        ];
        $update = DataKeluarga::where('parent_user', $request->user()->uuid)->where('is_auth', 0)->where('uid_keluarga', $request->uid)->update($data);
        if (!$update) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal memperbarui data keluarga.'
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Berhasil memperbarui data keluarga.'
        ], 200);
    }

    public function hapus_keluarga(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string|min:35|max:36',
        ]);

        $drop = DataKeluarga::where('parent_user', $request->user()->uuid)->where('is_auth', 0)->where('uid_keluarga', $request->uid)->delete();
        if (!$drop) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal menghapus data keluarga.'
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Berhasil menghapus data keluarga.'
        ], 200);
    }
}
