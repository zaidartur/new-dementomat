<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kategori_id', 'nama_aturan', 'rekomendasi', 'uid_rule'])]
class DataRuleSkrining extends Model
{
    /**
     * Get all of the rule_kondisi for the DataRuleSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rule_kondisi(): HasMany
    {
        return $this->hasMany(DataRuleKondisi::class, 'rule_uid', 'uid_rule');
    }

    /**
     * Get the categories that owns the DataRuleSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriSkrining::class, 'kategori_id', 'id');
    }
}
