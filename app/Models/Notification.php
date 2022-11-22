<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    protected $table='notification';

    protected $fillable = [
        'title',
        'body',
        'click_action'
    ];
}
