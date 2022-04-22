<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferPromotion extends Model
{
    use SoftDeletes;
    protected $table='offer_promotion';
    protected $fillable = [
        'frame_web_id',
        'offer_id',
    ];

    /**
     * Relations
     *
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class,'offer_id','id');
    }
}
