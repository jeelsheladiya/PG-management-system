<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomRequest extends Model
{
    protected $table = 'room_requests';
    protected $primaryKey = 'RequestID';
    public $timestamps = false;

    protected $fillable = [
        'MemberID',
        'RoomID',
        'RequestDate',
        'Status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }
}