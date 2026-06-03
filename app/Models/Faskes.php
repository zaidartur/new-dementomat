<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['faskes_id', 'nama_faskes', 'alamat_faskes', 'kec_id', 'desakel_id'])]
#[Hidden(['id', 'created_at', 'updated_at'])]
class Faskes extends Model
{
    use LogsActivity;

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['faskes_id', 'nama_faskes', 'alamat_faskes', 'kec_id', 'desakel_id'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

    /**
     * Get the kecamatan associated with the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kecamatan(): HasOne
    {
        return $this->hasOne(Kecamatan::class, 'kec_id', 'kec_id');
    }

    /**
     * Get the desa associated with the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function desa(): HasOne
    {
        return $this->hasOne(Desa::class, 'desakel_id', 'desakel_id');
    }

    /**
     * Get all of the kontak for the Faskes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kontak(): HasMany
    {
        return $this->hasMany(Kontak::class, 'id_faskes', 'faskes_id');
    }
}
