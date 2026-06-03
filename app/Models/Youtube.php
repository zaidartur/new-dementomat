<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['judul', 'embed_link', 'status'])]
class Youtube extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['judul', 'embed_link', 'status'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }
}
