<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['sesi_uid', 'parameter_uid', 'is_yes'])]
class DataResponseSkrining extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['sesi_uid', 'parameter_uid', 'is_yes'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

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
