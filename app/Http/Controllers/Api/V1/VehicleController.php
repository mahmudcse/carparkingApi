<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function index()
    {
        return VehicleResource::collection(Vehicle::all());
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return VehicleResource::make($vehicle);
    }


    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }


    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        return response()->json(
            VehicleResource::make($vehicle),
            Response::HTTP_ACCEPTED
        );
    }


    public function destroy(Vehicle $vehicle)
    {
        if (auth()->id() !== $vehicle->user_id) {
            return response()->json([
                'Message' => 'You do not have permission to delelte this data'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($vehicle->delete()) {
            return response()->noContent();
        }
    }
}
