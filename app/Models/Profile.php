<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['nama', 'alamat', 'email', 'telepon', 'deskripsi', 'koordinat', 'website', 'logo'])]
class Profile extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['nama', 'alamat', 'email', 'telepon', 'deskripsi', 'koordinat', 'website', 'logo'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }
}
