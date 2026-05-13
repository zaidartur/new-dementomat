<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
