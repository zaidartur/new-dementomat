<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    public function view()
    {
        if (Request()->user()->hasAnyRole(['superadmin', 'admin'])) {
            $list = Kontak::with('faskes')->get();
        } else {
            $list = Kontak::with('faskes')->where('uid_user', Request()->user()->uuid)->orWhere('id_faskes', Request()->user()->faskes_id)->get();
        }

        $data = [
            'lists'  => $list,
            'faskes' => Faskes::all(),
        ];
        return view('contacts.view', $data);
    }

    public function detail($uid)
    {
        $id = Crypt::decryptString($uid);
        if (!$id) return send_400('ID tidak ditemukan.');

        $kontak = Kontak::where('id', $id)->first();
        if (!$kontak) return send_400('Data tidak ditemukan.');

        $kontak->uid = Crypt::encryptString($kontak->id);
        $kontak->id  = 0;

        if (Request()->user()->hasAnyRole(['superadmin', 'admin'])) {
            return send_200('Detail kontak', $kontak);
        } else {
            if ($kontak->uid_user == Request()->user()->uuid) {
                return send_200('Detail kontak', $kontak);
            } else {
                return send_400('Data tidak ditemukan.');
            }
        }
    }

    public function simpan(Request $request)
    {
        if ($request->user()->hasAnyRole(['superadmin', 'admin'])) {
            return $this->simpan_by_admin($request);
        } else {
            return $this->simpan_by_faskes($request);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'uid'    => 'required|string'
        ]);

        $id = Crypt::decryptString($request->uid);
        if (!$id) return send_400('ID tidak diketahui.');

        if ($request->user()->hasAnyRole(['superadmin', 'admin'])) {
            return $this->simpan_by_admin($request, intval($id));
        } else {
            return $this->simpan_by_faskes($request, intval($id));
        }
    }

    private function simpan_by_admin($request, $id = null)
    {
        $request->validate([
            'judul'     => 'required|string|max:100',
            'nama'      => 'required|string|max:100',
            'phone'     => 'required|numeric|min_digits:9|max_digits:15',
            'faskes'    => 'required|string|min:35|max:36'
        ]);

        $data = [
            'judul_kontak'  => $request->judul,
            'nama_kontak'   => $request->nama,
            'nomor_wa'      => $request->phone,
            'id_faskes'     => $request->faskes,
        ];

        $save = empty($id) ? Kontak::create($data) : Kontak::where('id', $id)->update($data);
        if (!$save) return send_400('Gagal menyimpan kontak.');

        return send_201('Berhasil menyimpan kontak.');
    }

    private function simpan_by_faskes($request, $id = null)
    {
        $request->validate([
            'judul'     => 'required|string|max:100',
            'nama'      => 'required|string|max:100',
            'phone'     => 'required|numeric|min_digits:9|max_digits:15',
        ]);

        $data = [
            'judul_kontak'  => $request->judul,
            'nama_kontak'   => $request->nama,
            'nomor_wa'      => $request->phone,
            'id_faskes'     => Request()->user()->faskes_id,
            'uid_user'      => Request()->user()->uuid,
        ];

        $save = empty($id) ? Kontak::create($data) : Kontak::where('id', $id)->update($data);
        if (!$save) return send_400('Gagal menyimpan kontak.');

        return send_201('Berhasil menyimpan kontak.');
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string'
        ]);

        $id  = Crypt::decryptString($request->uid);
        if (!$id) return send_400('ID tidak diketahui.');

        $check = Kontak::where('id', intval($id))->first();
        if ($request->user()->hasRole('faskes') && ($check->id_faskes != $request->user()->faskes_id)) {
            return send_400('Role tidak sesuai.');
        }

        $del = Kontak::where('id', intval($id))->delete();
        if (!$del) return send_400('Gagal menghapus kontak.');

        return send_200('Data kontak berhasil dihapus.');
    }
}
