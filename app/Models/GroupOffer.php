<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupOffer extends Model
{
    use SoftDeletes;
    protected $table='group_offers';
    protected $fillable = [
        'name_group_es',
        'name_group_en',
        'category_id',
    ];

    /**
     * Relations
     */

    public function offers()
    {
        return $this->hasMany(Offer::class,'group_offer_id','id');
    }

    public function category()
    {
        return $this->belongsTo(GroupOffer::class, 'category_id','id');
    }

    public function subsCategory()
    {
        return $this->hasMany(GroupOffer::class,'category_id','id');
    }

    /**
     * Scope a query to only include category with group offers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory($query)
    {
        return $query->whereNull('category_id' );
    }

    /**
     * Scope a query to only include group offer with category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubCategory($query)
    {
        return $query->whereNotNull('category_id' );
    }
}
