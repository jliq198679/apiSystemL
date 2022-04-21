<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferDaily extends Model
{
    use SoftDeletes;
    protected $table='offers_daily';
    protected $fillable = [
        'frame_web_id',
        'offer_id',
        'price_cup',
        'price_usd',
        'count_offer'
    ];
}
