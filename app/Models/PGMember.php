<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class PGMember extends Authenticatable
{
    use Notifiable;
    protected $table = 'pgmember';
    protected $primaryKey = 'MemberID';
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Email',
        'AdhaarFile',
        'ProfilePic',
        'AdhaarNumber',
        'Password',
        'Phone',
        'ParentsMobile',
        'Course',
        'DOB',
        'Gender',
        'Address',
        'Pincode',
        'RoomID',
        'JoinDate',
        'OTP',
        'OTP_Expires_At',
        'IsVerified'
    ];

    //relations
    public function currentRoom()
    {
       return $this->hasOne(\App\Models\RoomAllocation::class, 'MemberID', 'MemberID')
                ->where('Status', 'Active')
                ->whereDate('AllocationDate', '<=', now());     
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID', 'RoomID');
    }

    public function allocations()
    {
        return $this->hasMany(RoomAllocation::class, 'MemberID', 'MemberID');
    }

    public function activeAllocation()
    {
        return $this->hasOne(RoomAllocation::class, 'MemberID', 'MemberID')
            ->where('Status', 'Active');
    }

    public function roomAllocations()
    {
        return $this->hasMany(RoomAllocation::class, 'MemberID');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'MemberID', 'MemberID');
    }
}
