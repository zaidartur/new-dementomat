<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class MobileUserController extends Controller
{
    public function profile()
    {
        $request = Request();
        $users = User::with(['detail', 'detail.kecamatan', 'detail.desa', 'detail.faskes', 'detail.faskes.kecamatan', 'detail.faskes.desa', 'detail.faskes.kontak'])
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
        $users = User::with(['detail', 'detail.sesiTerakhir', 'detail.kontak', 'keluarga', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.faskes', 'keluarga.faskes.kecamatan', 'keluarga.faskes.desa', 'keluarga.sesiTerakhir', 'keluarga.kontak'])
                ->where('uuid', $request->user()->uuid)
                ->select('uuid', 'username', 'name', 'email', 'created_at')
                ->first()
                ->makeHidden('level');
        if (!$users) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal menampilkan data keluarga.'
            ], 400);
        }

        $usia  = !empty($users->detail->tgl_lahir) ? Carbon::parse($users->detail->tgl_lahir) : null;
        $users->detail->usia = !empty($usia) ? CarbonInterval::instance($usia->diff(Carbon::now()))->locale('id')->forHumans(['parts' => 4, 'join' => ', ']) : null;
        if (!empty($users->detail->sesiTerakhir)) {
            $age = CarbonInterval::instance(Carbon::parse($users->detail->tgl_lahir)->diff(Carbon::parse($users->detail->sesiTerakhir->created_at)))->locale('id')->forHumans(['parts' => 4, 'join' => ', ']) ?? 0;
            $users->detail->sesiTerakhir->umur_lengkap_saat_skrining = $age;
            $users->detail->sesiTerakhir->url_file = route('tcm.file', Crypt::encryptString($users->detail->sesiTerakhir->uid_sesi));
        }

        if (count($users->keluarga) > 0) {
            foreach ($users->keluarga as $key => $value) {
                $umur = !empty($value->tgl_lahir) ? Carbon::parse($value->tgl_lahir) : null;
                $value->usia = !empty($umur) ? CarbonInterval::instance($umur->diff(Carbon::now()))->locale('id')->forHumans(['parts' => 4, 'join' => ', ']) : null;

                if (!empty($value->sesiTerakhir)) {
                    $age = CarbonInterval::instance(Carbon::parse($value->tgl_lahir)->diff(Carbon::parse($value->sesiTerakhir->created_at)))->locale('id')->forHumans(['parts' => 4, 'join' => ', ']) ?? 0;
                    $value->sesiTerakhir->umur_lengkap_saat_skrining = $age;
                    $value->sesiTerakhir->url_file_tcm = route('tcm.file', Crypt::encryptString($value->sesiTerakhir->uid_sesi));
                }
            }
        }

        return response()->json($users, 200, [], JSON_UNESCAPED_SLASHES);
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
            'email'     => "nullable|email|max:150|unique:users,email,{$request->user()->id}",
            'alamat_nik'=> 'required|string',
            'dob'       => 'required|date',
            'jenkel'    => 'required|string|max:2',
            'status'    => 'nullable|string',
            'alamat'    => 'required|string',
            'telepon'   => 'required|numeric',
            'kecamatan' => 'required|numeric',
            'desa'      => 'required|numeric',
            'faskes'    => 'required|string|min:35|max:36',
        ]);

        // check no hp
        if (!empty($request->telepon) && !str_starts_with($request->telepon, '628')) {
            return send_400('Format nomor telepon tidak sesuai. Mohon menggunakan awalan 628xxx');
        }
        if (!empty($request->email)) {
            if (User::where('email', $request->email)->where('id', '!=', $request->user()->id)->exists()) return send_400('Alamat email sudah digunakan.');
        }

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
        $update = DataKeluarga::where('uid_keluarga', $request->user()->uuid)->where('is_auth', 1)->update($data);
        if (!$update) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal memperbarui biodata.'
            ], 400);
        }

        User::where('uuid', $request->user()->uuid)->update(['name' => $request->nama, 'email' => ($request->email ?? $request->user()->email)]);
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

        // check NIK
        if (DataKeluarga::where('nik', $request->nik)->exists()) {
            return send_400('NIK sudah ada di database.');
        }

        // check no hp
        if (!empty($request->telepon) && !str_starts_with($request->telepon, '628')) {
            return send_400('Format nomor telepon tidak sesuai. Mohon menggunakan awalan 628xxx');
        }

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
        ], 201);
    }

    public function update_keluarga(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|min:35|max:36',
            'nama'      => 'required|string',
            'nik'       => 'required|numeric|min_digits:15|max_digits:16',
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

        // check no hp
        if (!empty($request->telepon) && !str_starts_with($request->telepon, '628')) {
            return send_400('Format nomor telepon tidak sesuai. Mohon menggunakan awalan 628xxx');
        }

        $data = [
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
        $update = DataKeluarga::where('parent_user', $request->user()->uuid)->where('is_auth', 0)->where('uid_keluarga', $request->uuid)->update($data);
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
            'uuid'   => 'required|string|min:35|max:36',
        ]);

        // prevent user login delete data it-self
        if ($request->uuid == $request->user()->uuid) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'User tidak bisa menghapus data dirinya sendiri.'
            ], 401);
        }

        $drop = DataKeluarga::where('parent_user', $request->user()->uuid)->where('is_auth', 0)->where('uid_keluarga', $request->uuid)->delete();
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
