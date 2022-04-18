<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $table='offers';
    protected $fillable = [
        'name_offer',
        'description_offer',
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
}
