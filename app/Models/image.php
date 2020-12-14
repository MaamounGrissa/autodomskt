<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'filename',
        'url',
    ];

    public function category()
    {
        return $this->hasOne('App\category');
    }
}
