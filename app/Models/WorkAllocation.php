<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkAllocation extends Model
{
    protected $table = 'WorkAllocation';
    protected $primaryKey = 'WorkID';
    public $timestamps = false;

    protected $fillable = [
        'StaffID',
        'WorkType',
        'Description',
        'AssignDate',
        'Status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'StaffID','StaffID');
    }
}
