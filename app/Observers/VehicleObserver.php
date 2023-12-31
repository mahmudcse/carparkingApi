<?php

namespace App\Observers;

use App\Models\Vehicle;

class VehicleObserver
{
    public function creating(Vehicle $vehicle)
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }
    public function created(Vehicle $vehicle)
    {
        //
    }

    public function updating(Vehicle $vehicle)
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }
    public function updated(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "deleted" event.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return void
     */
    public function deleted(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "restored" event.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return void
     */
    public function restored(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "force deleted" event.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return void
     */
    public function forceDeleted(Vehicle $vehicle)
    {
        //
    }
}
