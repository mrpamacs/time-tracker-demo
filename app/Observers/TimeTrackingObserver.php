<?php

namespace App\Observers;

use App\Models\TimeTracking;
use Illuminate\Support\Facades\Auth;

class TimeTrackingObserver
{
    public function creating(TimeTracking $timeTracking){
        $timeTracking->user_id = Auth::user()->id;
    }
    /**
     * Handle the TimeTracking "created" event.
     */
    public function created(TimeTracking $timeTracking): void
    {
        //
    }

    /**
     * Handle the TimeTracking "updated" event.
     */
    public function updated(TimeTracking $timeTracking): void
    {
        //
    }

    /**
     * Handle the TimeTracking "deleted" event.
     */
    public function deleted(TimeTracking $timeTracking): void
    {
        //
    }

    /**
     * Handle the TimeTracking "restored" event.
     */
    public function restored(TimeTracking $timeTracking): void
    {
        //
    }

    /**
     * Handle the TimeTracking "force deleted" event.
     */
    public function forceDeleted(TimeTracking $timeTracking): void
    {
        //
    }
}
