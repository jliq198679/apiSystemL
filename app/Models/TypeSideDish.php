<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSideDish extends Model
{
    use SoftDeletes;
    protected $table='type_side_dish';

    protected $fillable = [
        'name_type_side_dish_es',
        'name_type_side_dish_en'
    ];
}
