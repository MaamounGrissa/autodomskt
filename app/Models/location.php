<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'state',
        'order',
    ];
}
