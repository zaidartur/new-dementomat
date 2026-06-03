<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['judul_kontak', 'nama_kontak', 'nomor_wa', 'id_faskes', 'uid_user', 'jenis_kontak'])]
#[Hidden(['uid_user'])]
class Kontak extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['judul_kontak', 'nama_kontak', 'nomor_wa', 'id_faskes', 'uid_user', 'jenis_kontak'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

    /**
     * Get the faskes that owns the Kontak
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faskes(): BelongsTo
    {
        return $this->belongsTo(Faskes::class, 'id_faskes', 'faskes_id');
    }

    /**
     * Get the user associated with the Kontak
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'uuid', 'uid_user');
    }
}
