<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    //
    protected $table = 'amenities';
    protected $primaryKey = 'AmenityID';
    public $timestamps = false;

    protected $fillable = [
        'AmenityName',
        'Description',
        'Status'
    ];

}
