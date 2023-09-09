<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParkingResource;
use App\Http\Requests\StoreParkingRequest;
use App\Services\ParkingPriceService;

class ParkingController extends Controller
{
    public function start(StoreParkingRequest $request){

        $parking = Parking::create([
            'user_id'    => $request->user()->id,
            'zone_id'    => $request->zone_id,
            'vehicle_id' => $request->vehicle_id,
            'start_time' => now()
        ]);

        $parkingData = $parking->load('zone', 'vehicle');

        return ParkingResource::make($parkingData);
    }

    public function show($parking){

        $parkingData = Parking::with('zone', 'vehicle')
        ->where('user_id', auth()->id())
        ->where('id', $parking)
        ->first();

        return ParkingResource::make($parkingData);
    }

    public function stop($parking, ParkingPriceService $calculatePriceService){
        $parkingData = Parking::with('zone', 'vehicle')
        ->where('user_id', auth()->id())
        ->where('id', $parking)
        ->first();

        $totalPrice = $calculatePriceService->calculatePrice($parkingData->zone_id, $parkingData->start_time, $parkingData->stop_time);


        $parkingData = $parkingData->update([
            'stop_time' => now(),
            'total_price' => $totalPrice
        ]);

        $updatedParking = Parking::with('zone', 'vehicle')->where('id', $parking)->first();

        return ParkingResource::make($updatedParking);
    }
}
