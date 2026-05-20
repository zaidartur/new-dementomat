<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['uid_keluarga', 'tanggal', 'gejala_awal', 'efek_mual', 'efek_pipis_merah', 'efek_pendengaran', 'efek_penglihatan', 'efek_pegal', 'efek_batuk', 'efek_demam'])]
class PantauanObat extends Model
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
