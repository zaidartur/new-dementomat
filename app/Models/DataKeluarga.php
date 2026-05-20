<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['uid_keluarga', 'parent_user', 'is_auth', 'nama_lengkap', 'nik', 'alamat_nik', 'telepon', 'alamat', 'tgl_lahir', 'jenkel', 'status_keluarga', 'kec_id', 'desakel_id', 'id_faskes', 'status_tbc', 'tgl_mulai_obat'])]
#[Hidden(['is_auth', 'id', 'parent_user'])]
class DataKeluarga extends Model
{
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
     * Get all of the kontak for the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kontak(): HasMany
    {
        return $this->hasMany(Kontak::class, 'id_faskes', 'id_faskes');
    }

    /**
     * Get the faskes that owns the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faskes(): BelongsTo
    {
        return $this->belongsTo(Faskes::class, 'id_faskes', 'faskes_id');
    }

    /**
     * Get all of the sesi for the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesi(): HasMany
    {
        return $this->hasMany(DataSesiSkrining::class, 'uid_keluarga', 'uid_keluarga');
    }

    /**
     * Get the sesiTerakhir associated with the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sesiTerakhir(): HasOne
    {
        return $this->hasOne(DataSesiSkrining::class, 'uid_keluarga', 'uid_keluarga')->latestOfMany('created_at');
    }

    /**
     * Get all of the obat for the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function obat(): HasMany
    {
        return $this->hasMany(PantauanObat::class, 'uid_keluarga', 'uid_keluarga');
    }

    /**
     * Get the obatTerakhir associated with the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function obatTerakhir(): HasOne
    {
        return $this->hasOne(PantauanObat::class, 'uid_keluarga', 'uid_keluarga')->latestOfMany('tanggal');
    }

    /**
     * Get all of the berat for the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function berat(): HasMany
    {
        return $this->hasMany(PantauanBeratBadan::class, 'uid_keluarga', 'uid_keluarga');
    }

    /**
     * Get the beratTerakhir associated with the DataKeluarga
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function beratTerakhir(): HasOne
    {
        return $this->hasOne(PantauanBeratBadan::class, 'uid_keluarga', 'uid_keluarga');
    }
}
