<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table='municipality';

    protected $fillable = [
        'id',
        'name',
    ];
}
