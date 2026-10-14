<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    protected $primaryKey = 'LeaveID';
    public $timestamps = false;

    protected $fillable = [
        'MemberID',
        'AllocationID',
        'RequestDate',
        'Status'
    ];
}
