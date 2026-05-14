<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['uid_keluarga', 'parent_user', 'is_auth', 'nama_lengkap', 'nik', 'alamat_nik', 'telepon', 'alamat', 'tgl_lahir', 'jenkel', 'status_keluarga', 'kec_id', 'desakel_id', 'id_faskes', 'status_tbc'])]
#[Hidden(['is_auth', 'id', 'parent_user'])]
class DataKeluarga extends Model
{
    /**
     * Get the kecamatan associated with the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kecamatan(): HasOne
    {
        return $this->hasOne(Kecamatan::class, 'kec_id', 'kec_id');
    }

    /**
     * Get the desa associated with the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function desa(): HasOne
    {
        return $this->hasOne(Desa::class, 'desakel_id', 'desakel_id');
    }

    /**
     * Get the faskes associated with the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function faskes(): HasOne
    {
        return $this->hasOne(Faskes::class, 'faskes_id', 'id_faskes');
    }
}
