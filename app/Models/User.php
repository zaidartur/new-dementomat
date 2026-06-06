<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Override;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['uuid', 'username', 'name', 'email', 'password', 'level'])]
#[Hidden(['id', 'password', 'remember_token', 'email_verified_at', 'deleted_at'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens, LogsActivity;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    #[Override]
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['uuid', 'username', 'name', 'email', 'password', 'level', 'faskes_id'])
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs();
    }

    /**
     * Get the detail associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail(): HasOne
    {
        return $this->hasOne(DataKeluarga::class, 'uid_keluarga', 'uuid');
    }

    /**
     * Get all of the keluarga for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keluarga(): HasMany
    {
        return $this->hasMany(DataKeluarga::class, 'parent_user', 'uuid');
    }

    /**
     * Get the faskes associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function faskes(): HasOne
    {
        return $this->hasOne(Faskes::class, 'faskes_id', 'faskes_id');
    }
}
