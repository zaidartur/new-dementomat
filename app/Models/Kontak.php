<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['judul_kontak', 'nama_kontak', 'nomor_wa', 'id_faskes', 'uid_user'])]
#[Hidden(['uid_user'])]
class Kontak extends Model
{
    /**
     * Get the faskes associated with the Kontak
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function faskes(): HasOne
    {
        return $this->hasOne(Faskes::class, 'faskes_id', 'id_faskes');
    }

    /**
     * Get the user associated with the Kontak
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'uuid', 'uid_user');
    }
}
