<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Zone;

class ParkingPriceService
{
    public static function calculatePrice($zone_id, $start_time, $stop_time): int
    {
        $zonePricePerHour = Zone::find($zone_id)->price_per_hour;

        $zonePricePerMinut = ceil($zonePricePerHour / 60);

        $startTime = new Carbon($start_time);
        $stopTime = new Carbon(is_null($stop_time) ? now() : $stop_time);
        $parkedTimeInMinut = $stopTime->diffInMinutes($startTime);

        return ceil($parkedTimeInMinut * $zonePricePerMinut);
    }
}
