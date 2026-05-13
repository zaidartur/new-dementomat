<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['faskes_id', 'nama_faskes', 'alamat_faskes', 'kec_id', 'desakel_id'])]
#[Hidden(['id', 'created_at', 'updated_at'])]
class Faskes extends Model
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
}
