<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Faskes;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function pengguna()
    {
        $data = [
            'lists' => User::where('level', 'user')->get(),
            'kec'   => Kecamatan::all(),
            'faskes'=> Faskes::all(),
        ];

        return view('users.pengguna', $data);
    }

    public function detail_pengguna($uid)
    {
        $user = User::with(['detail', 'keluarga'])->where('uuid', $uid)->first();
        if (!$user) {
            return send_400('Gagal mengakses data user. Atau mungkin user tidak data di database.');
        }

        return send_200('Data user ' . $user->name, $user);
    }

    public function update_username_pengguna(Request $request)
    {
        $request->validate([
            'username'  => 'required|string'
        ]);

        $find = User::where('username', $request->username)->first();
        if ($find) {
            return send_400('Username "' . $request->username . '" sudah digunakan.');
        }

        $user = User::where('uuid', $request->user()->uuid)->update(['username', $request->username]);
        if (!$user) {
            return send_400('Username gagal diubah.');
        }

        return send_200('Username berhasil diubah.');
    }

    public function update_password_pengguna(Request $request)
    {
        $request->validate([
            'uuid'      => 'required|string|min:35|max:36',
            'password'  => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('uuid', $request->uuid)->whereNull('created_at')->first();
        if (!$user) {
            send_400('Data pengguna tidak ditemukan di database.');
        }

        $upd = User::where('uuid', $request->uuid)->update(['password' => Hash::make($request->password)]);
        if (!$upd) {
            send_500('Gagal mengubah password pengguna.');
        }

        // drop user PAN
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        return send_200('Password pengguna ' . $user->name . ' berhasil diubah.');
    }

    public function hapus_pengguna(Request $request)
    {
        $request->validate([
            'uuid'  => 'required|string|min:35|max:36',
        ]);

        $check = User::where('uuid', $request->uuid)->first();
        $del = User::where('uuid', $request->uuid)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        if ($del) {
            // drop user PAN
            DB::table('personal_access_tokens')->where('tokenable_id', $check->id)->delete();
        } else {
            return send_500('Gagal menghapus user.');
        }
    }

    public function simpan_keluarga(Request $request)
    {
        //
    }

    public function update_keluarga(Request $request)
    {
        //
    }

    public function hapus_keluarga(Request $request)
    {
        //
    }

    public function ss_pengguna()
    {
        $request = Request();
        $start  = $request->start;
        $length = $request->length;
        $page   = $request->page;
        $size   = $request->size;
        $faskes = (isset($request->faskes) && !empty($request->faskes)) ? $request->faskes : null;
        $kec    = (isset($request->kecamatan) && !empty($request->kecamatan)) ? $request->kecamatan : null;
        $total  = User::where('level', 'user')->whereNull('deleted_at')->orderBy('name')->count();

        $query  = User::with(['detail', 'keluarga']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
                    // ->orWhere('detail_useers.alamat_nik', 'like', "%$search%")
                    // ->orWhere('users.name', 'like', "%$search%")
            });
        }
        if (!empty($faskes)) {
            $query->whereHas('detail', function($que) use ($faskes) {
                $que->where('id_faskes', $faskes);
            });
        }
        if (!empty($kec)) {
            $query->whereHas('detail', function($que) use ($kec) {
                $que->where('kec_id', $kec);
            });
        }

        $query->whereNull('deleted_at');
        $query->where('level', 'user');
        $totalFiltered = $query->count();
        $query->orderBy('created_at', 'desc');
        // $query->skip($start)->take($length);
        $query->skip(intval($page)-1)->take(intval($size));

        $users  = $query->get();
        $data   = [];
        foreach ($users as $key => $value) {
            $nik = $request->nik == 'show' ? ($value->detail->nik ?? '-') : (!empty($value->detail->nik) ? substr($value->detail->nik, 0, 4) . str_repeat("*", strlen($value->detail->nik) - 4) : '-');
            $data[] = [
                'nama'      => $value->name,
                'username'  => $value->username,
                'nik'       => $nik,
                'faskes'    => $value->detail->faskes->nama_faskes ?? '-',
                'id_faskes' => $value->detail->id_faskes,
                'alamat'    => $value->detail->alamat ?? '-',
                'kecamatan' => $value->detail->kecamatan->kec_name ?? '-',
                'id_kec'    => $value->detail->kec_id,
                'desa'      => $value->detail->desa->desakel_name ?? '-',
                'keluarga'  => count($value->keluarga) ?? 0,
                'usia'      => 0,
                'opsi'      => '
                        <span class="inline-flex gap-2.5">
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_detail(`' .$value->uuid. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Lihat Detail</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_edit(`' .$value->uuid. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil" aria-hidden="true">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                    <path d="m15 5 4 4"></path>
                                </svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">Edit Pengguna</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_delete(`' .$value->uuid. '`)" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash" aria-hidden="true">
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                    <span class="flex items-center gap-1.5">
                                        Hapus Pengguna
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"class="lucide lucide-triangle-alert text-yellow-500 size-4" aria-hidden="true">
                                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                                            <path d="M12 9v4"></path>
                                            <path d="M12 17h.01"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </span>
                '
            ];
        }

        return response()->json([
            'draw' => intval($request->draw) ?? 0,
            'recordsTotal'  => $total,
            'recordsFiltered' => $totalFiltered,
            'data'          => $data,
            'page'          => $page,
            'size'          => $size,
        ]);
    }
}
