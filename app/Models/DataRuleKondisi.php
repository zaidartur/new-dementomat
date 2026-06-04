<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['parameter_uid', 'rule_uid'])]
class DataRuleKondisi extends Model
{
    /**
     * Get the parameter that owns the DataRuleKondisi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(MasterParameterSkrining::class, 'parameter_uid', 'uid_parameter');
    }

    /**
     * Get the ruleScreening that owns the DataRuleKondisi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruleScreening(): BelongsTo
    {
        return $this->belongsTo(DataRuleSkrining::class, 'rule_uid', 'uid_rule');
    }
}
