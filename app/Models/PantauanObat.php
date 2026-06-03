<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['uid_keluarga', 'uid_sesi', 'tanggal', 'gejala_awal', 'efek_mual', 'efek_pipis_merah', 'efek_pendengaran', 'efek_penglihatan', 'efek_pegal', 'efek_batuk', 'efek_demam'])]
class PantauanObat extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['uid_keluarga', 'uid_sesi', 'tanggal', 'gejala_awal', 'efek_mual', 'efek_pipis_merah', 'efek_pendengaran', 'efek_penglihatan', 'efek_pegal', 'efek_batuk', 'efek_demam'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

    /**
     * Get the keluarga that owns the PantauanObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(DataKeluarga::class, 'uid_keluarga', 'uid_keluarga');
    }

    /**
     * Get the sesi that owns the PantauanObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(DataSesiSkrining::class, 'uid_sesi', 'uid_sesi');
    }
}
