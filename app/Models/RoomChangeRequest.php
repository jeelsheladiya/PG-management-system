<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomChangeRequest extends Model
{
    //
    protected $table = 'RoomChangeRequest';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //

    protected $fillable = [
        'MemberID',
        'OldRoomID',
        'NewRoomID',
        'Reason',
        'Status'
    ];

    public function member()
    {
        
        return $this->belongsTo(PGMember::class, 'MemberID', 'MemberID');
    }

    public function oldRoom()
    {
        return $this->belongsTo(Room::class, 'OldRoomID', 'RoomID');
    }

    public function newRoom()
    {
        return $this->belongsTo(Room::class, 'NewRoomID', 'RoomID');
    }
}
