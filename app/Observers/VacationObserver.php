<?php

namespace App\Observers;

use App\Models\Vacation;
use App\Events\VacationEvent;
use App\Notifications\VacationNotification;
use Illuminate\Support\Facades\Notification;

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
        $ancestors = auth()->user()->ancestors;

        foreach ( $ancestors as $ancestor ) {
            if ($ancestor->role == 'admin') {
                $text = 'Employee ' . auth()->user()->name . ' from department ' . auth()->user()->department->name .  ' send request for vacation';
            } else{
                $text = 'Employee ' . auth()->user()->name . ' send request for vacation';
            }
            Notification::send($ancestor, new VacationNotification($text, $vacation->id));
            event(new VacationEvent($ancestor->id));
        }

    }

    /**
     * Handle the Vacation "updating" event.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return void
     */
    public function updating(Vacation $vacation)
    {
        if (auth()->user()->role == 'admin') {
            $text = 'Admin ' . auth()->user()->name . ' ' . $vacation->status->name . ' your request';
        } else{
            $text = 'Manager ' . auth()->user()->name . ' ' . $vacation->status->name . ' your request';
        }
        Notification::send($vacation->user, new VacationNotification($text, $vacation->id));
        event(new VacationEvent($vacation->user->id));
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
