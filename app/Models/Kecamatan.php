<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['kec_id', 'kec_name', 'kotakab_id'])]
#[Hidden(['id', 'kotakab_id', 'created_at', 'updated_at'])]
class Kecamatan extends Model
{
    //
}
