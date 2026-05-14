<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['desakel_id', 'kec_id', 'desakel_name'])]
#[Hidden(['id', 'created_at', 'updated_at'])]
class Desa extends Model
{
    /**
     * Get the kecamatan that owns the Desa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kec_id', 'kec_id');
    }
}
