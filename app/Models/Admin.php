<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'Admin';
    protected $primaryKey = 'AdminID';
    public $timestamps = false;

    public function notices()
    {
        return $this->hasMany(Notice::class, 'AdminID', 'AdminID');
    }

}
