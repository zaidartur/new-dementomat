<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['kategori_id', 'pertanyaan', 'kode', 'uid_parameter'])]
class MasterParameterSkrining extends Model
{
    /**
     * Get the category that owns the MasterParameterSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriSkrining::class, 'kategori_id', 'id');
    }
}
