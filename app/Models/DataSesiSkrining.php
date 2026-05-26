<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['uid_sesi', 'uid_keluarga', 'kategori_id', 'umur_saat_skrining', 'triggered_rule_id', 'location', 'tgl_tcm', 'hasil_tcm', 'file_tcm', 'jenis_tcm'])]
class DataSesiSkrining extends Model
{
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
}
