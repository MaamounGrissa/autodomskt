<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'parent',
        'order',
        'image_id',
    ];

    public function image() {
        return $this->belongsTo('App\Models\image','image_id');
    }
}
