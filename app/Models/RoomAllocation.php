<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAllocation extends Model
{
    protected $table = 'RoomAllocation';
    protected $primaryKey = 'AllocationID';
    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'MemberID',
        'RoomID',
        'AllocationDate',
        'ReleaseDate',
        'Status'
    ];

    //  Relationships
    public function member()
    {
        return $this->belongsTo(PGMember::class, 'MemberID', 'MemberID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID', 'RoomID');
    }



    // RoomAllocation model
    public function payment()
    {
        return $this->hasOne(Payment::class, 'AllocationID', 'AllocationID');
    }


}
