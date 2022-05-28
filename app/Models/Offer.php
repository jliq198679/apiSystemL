<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $table='offers';
    protected $fillable = [
        'name_offer_en',
        'name_offer_es',
        'description_offer_en',
        'description_offer_es',
        'url_imagen',
        'group_offer_id'
    ];

    /**
     * Relations
     */

    public function groupOffer()
    {
        return $this->belongsTo(GroupOffer::class,'group_offer_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function offerDaily()
    {
        return $this->hasOne(OfferDaily::class,'offer_id','id')
            ->whereRaw('date(offers_daily.created_at) = curdate()')
            ;
    }
}
