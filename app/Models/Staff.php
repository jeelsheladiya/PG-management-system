<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'Staff';
    protected $primaryKey = 'StaffID';
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Gender',
        'Email',
        'AadharNumber',
        'Password',
        'Phone',
        'Role',
        'HireDate'
    ];

    protected $hidden = ['Password'];

    public function workAllocations()
    {
        return $this->hasMany(WorkAllocation::class, 'StaffID');
    }

    public function works()
    {
        return $this->hasMany(WorkAllocation::class, 'StaffID', 'StaffID');
    }

}
