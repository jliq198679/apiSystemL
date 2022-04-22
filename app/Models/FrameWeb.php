<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FrameWeb extends Model
{
    use SoftDeletes;
    protected $table='frames_web';
    protected $fillable = [
        'frame_name',
        'payload_frame',
        'active',
        'type'
    ];
    protected $casts= [
        'payload_frame' => 'array'
    ];

    /**
     * Relations
     */
    public function promotionOffers()
    {
        return $this->belongsToMany(
            Offer::class,
            'offer_promotion',
            'frame_web_id',
            'offer_id'
        );
    }

}
