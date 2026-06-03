<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
