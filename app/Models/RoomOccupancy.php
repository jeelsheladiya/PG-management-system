<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomOccupancy extends Model
{
    protected $table = 'RoomOccupancy';
    protected $primaryKey = 'RoomID';
    public $timestamps = false;

    protected $fillable = [
        'RoomID',
        'CurrentOccupancy',
        'VacantBeds',
        'Status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID', 'RoomID');
    }
}
