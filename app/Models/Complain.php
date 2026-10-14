<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'Complain';
    protected $primaryKey = 'ComplainID';
    public $timestamps = false;
    // mass assignment protection
    protected $fillable = [
        'MemberID',
        'StaffID',
        'Category',
        'ComplainText',
        'Status',
        'DateRaised',
        'DateResolved'
    ];


    public function member()
    {
        return $this->belongsTo(PGMember::class, 'MemberID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'StaffID');
    }




}
