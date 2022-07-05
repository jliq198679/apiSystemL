<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SideDish extends Model
{
    use SoftDeletes;
    protected $table='side_dish';

    protected $fillable = [
        'type_side_dish_id',
        'name_side_dish_es',
        'name_side_dish_en',
        'price_cup',
        'price_usd'
    ];
}
