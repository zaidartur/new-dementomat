<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['uid_keluarga', 'bulan_live', 'bulan_ke', 'berat_badan'])]
class PantauanBeratBadan extends Model
{
    /**
     * Get the keluarga that owns the PantauanObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(DataKeluarga::class, 'uid_keluarga', 'uid_keluarga');
    }
}
