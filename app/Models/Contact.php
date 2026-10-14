<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
protected $table = 'contacts';
protected $fillable = ['name', 'sname', 'mobile', 'email', 'txtarea'];
public $timestamps = false; // જો તમે ફક્ત created_at રાખ્યું હોય તો
}