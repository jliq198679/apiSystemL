<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryPlace extends Model
{
    use SoftDeletes;
    protected $table='delivery_place';

    protected $fillable = [
        'municipality_id',
        'name',
        'price'
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class,'municipality_id','id');
    }
}
