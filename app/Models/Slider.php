<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['slider_id', 'foto_slider', 'keterangan', 'status'])]

class Slider extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['slider_id', 'foto_slider', 'keterangan', 'status'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }
}
