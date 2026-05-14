<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kec_id', 'kec_name', 'kotakab_id'])]
#[Hidden(['id', 'kotakab_id', 'created_at', 'updated_at'])]
class Kecamatan extends Model
{
    /**
     * Get all of the desa for the Kecamatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desa(): HasMany
    {
        return $this->hasMany(Desa::class, 'kec_id', 'kec_id');
    }
}
