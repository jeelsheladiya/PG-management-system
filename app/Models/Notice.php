<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'Notice';
    protected $primaryKey = 'NoticeID';
    public $timestamps = false;

    protected $fillable = [
        'AdminID',
        'Title',
        'Message',
        'DatePosted'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }

}
