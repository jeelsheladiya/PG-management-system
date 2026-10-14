<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'Room';
    protected $primaryKey = 'RoomID';
    public $timestamps = false;

    protected $fillable = [
        'RoomNumber',
        'Capacity',
        'Floor',
        'Status'
    ];
    public function occupancy()
    {
        return $this->hasOne(RoomOccupancy::class, 'RoomID', 'RoomID');
    }
    public function pricing()
    {
        return $this->hasOne(RoomPricing::class, 'Capacity', 'Capacity');
    }

    public function pricingVisiter()
    {
        // Aa hamesha RoomPricing table mathi chelli entry fetch karshe
        return $this->hasOne(RoomPricing::class, 'Capacity', 'Capacity')->latestOfMany('PricingID');
    }

    public function roomOccupancy()
    {
        return $this->hasOne(RoomOccupancy::class, 'RoomID', 'RoomID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID', 'RoomID');
    }

}
