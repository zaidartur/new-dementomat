<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['uid_sesi', 'uid_keluarga', 'kategori_id', 'umur_saat_skrining', 'triggered_rule_id', 'location', 'tgl_tcm', 'hasil_tcm', 'file_tcm', 'jenis_tcm', 'status_skrining', 'alasan_batal'])]
class DataSesiSkrining extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['uid_sesi', 'uid_keluarga', 'kategori_id', 'umur_saat_skrining', 'triggered_rule_id', 'location', 'tgl_tcm', 'hasil_tcm', 'file_tcm', 'jenis_tcm', 'status_skrining', 'alasan_batal'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

    /**
     * Get the keluarga that owns the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(DataKeluarga::class, 'uid_keluarga', 'uid_keluarga');
    }

    /**
     * Get the kategori that owns the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriSkrining::class, 'kategori_id', 'id');
    }

    /**
     * Get the triggeredRule that owns the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function triggeredRule(): BelongsTo
    {
        return $this->belongsTo(DataRuleSkrining::class, 'triggered_rule_id', 'uid_rule');
    }

    /**
     * Get all of the dataResponse for the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataResponse(): HasMany
    {
        return $this->hasMany(DataResponseSkrining::class, 'sesi_uid', 'uid_sesi');
    }

    /**
     * Get all of the logHarian for the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logHarian(): HasMany
    {
        return $this->hasMany(PantauanObat::class, 'uid_sesi', 'uid_sesi');
    }

    /**
     * Get all of the isYes for the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function isYes(): HasMany
    {
        return $this->hasMany(DataResponseSkrining::class, 'sesi_uid', 'uid_sesi')->where('is_yes', 1);
    }

    /**
     * Get all of the isNo for the DataSesiSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function isNo(): HasMany
    {
        return $this->hasMany(DataResponseSkrining::class, 'sesi_uid', 'uid_sesi')->where('is_yes', 0);
    }
}
