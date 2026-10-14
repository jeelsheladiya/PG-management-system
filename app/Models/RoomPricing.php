<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomPricing extends Model
{
    protected $table = 'room_pricing';

    protected $primaryKey = 'PricingID';

    public $timestamps = true;

    protected $fillable = [
        'Capacity',
        'MonthlyRent',
        'DailyRent',
        'EffectiveFrom',
    ];

    
}
