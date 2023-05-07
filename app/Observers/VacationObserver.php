<?php

namespace App\Observers;

use App\Models\Vacation;

class VacationObserver
{
    /**
     * Handle the Vacation "created" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    // public function created(Vacation $vacation)
    public function created(Vacation $vacation)
    {
        event(new \App\Events\VacationEvent(auth()->user()->id));
    }

    /**
     * Handle the Vacation "updating" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function updating(Vacation $vacation)
    {
        $vacation->employee_read = 0;
        event(new \App\Events\VacationEvent());
    }

    /**
     * Handle the Vacation "updated" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function updated(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "deleted" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function deleted(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "restored" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function restored(Vacation $vacation)
    {
        //
    }

    /**
     * Handle the Vacation "force deleted" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function forceDeleted(Vacation $vacation)
    {
        //
    }
}
