<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sesi_uid', 'parameter_uid', 'is_yes'])]
class DataResponseSkrining extends Model
{
    /**
     * Get the parameter that owns the DataResponseSkrining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(MasterParameterSkrining::class, 'parameter_uid', 'uid_parameter');
    }
}
