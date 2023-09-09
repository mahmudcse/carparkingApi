<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;

class ZoneController extends Controller
{
    public function index(){
        $zones = Zone::all();

        return ZoneResource::collection($zones);
    }
}
