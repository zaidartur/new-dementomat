<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['uuid_user', 'nik', 'alamat_nik', 'telepon', 'alamat', 'kec_id', 'desakel_id', 'id_faskes'])]
class DetailUser extends Model
{
    //
}
