<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupOffer extends Model
{
    use SoftDeletes;
    protected $table='group_offers';
    protected $fillable = [
        'name_group',
    ];
}
