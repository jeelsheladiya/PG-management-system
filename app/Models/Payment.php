<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'PaymentID';

    protected $fillable = [
        'MemberID',
        'AllocationID',
        'PeriodStart',
        'PeriodEnd',
        'RentAmount',   // full rent (Payable)
        'DepositAmount',
        'FineAmount',
        'TotalAmount',  // already paided (Paid)
        'PaymentDate',
        'PaymentMode',
        'Status',
        'PaymentFor'
    ];

    protected $casts = [
        'PeriodStart' => 'date',
        'PeriodEnd' => 'date',
        'PaymentDate' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(PGMember::class, 'MemberID', 'MemberID');
    }

    public function allocation()
    {
        return $this->belongsTo(RoomAllocation::class, 'AllocationID', 'AllocationID');
    }

    public function room()
    {
        return $this->hasOneThrough(Room::class, RoomAllocation::class, 'AllocationID', 'RoomID', 'AllocationID', 'RoomID');
    }
}
