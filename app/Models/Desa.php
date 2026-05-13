<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['desakel_id', 'kec_id', 'desakel_name'])]
#[Hidden(['id', 'created_at', 'updated_at'])]
class Desa extends Model
{
    //
}
