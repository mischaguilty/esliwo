<?php

namespace App\Observers;

use App\Models\Vehicle;

class VehicleObserver
{
    /**
     * Handle the Vehicle "created" event.
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function created(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "updated" event.
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function updated(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "deleted" event.
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function deleted(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "restored" event.
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function restored(Vehicle $vehicle)
    {
        //
    }

    /**
     * Handle the Vehicle "force deleted" event.
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function forceDeleted(Vehicle $vehicle)
    {
        //
    }
}
