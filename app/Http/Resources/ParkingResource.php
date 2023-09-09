<?php

namespace App\Http\Resources;

use App\Models\Zone;
use App\Services\ParkingPriceService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ParkingResource extends JsonResource
{

    public function toArray($request)
    {
        $totalPrice = is_null($this->total_price) ? ParkingPriceService::calculatePrice($this->zone_id, $this->start_time, $this->stop_time) : $this->total_price;

        
        return [
            'user_id'            => $this->user_id,
            'zone'               => [
                'name'           => $this->zone->name,
                'price_per_hour' => $this->zone->price_per_hour
            ],
            'vehicle'            => [
                'plate_number'   => $this->vehicle->plate_number
            ],
            'start_time'         => $this->start_time,
            'stop_time'          => $this->stop_time,
            'total_price' => $totalPrice,
        ];
    }
}
