<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\TimeTracking as TimeTrackingModel;
use Livewire\Component;

class TimeTracker extends Component
{
    public $selectedProject;
    public $elapsedTime = 0;
    public $timer;
    public $showModal = false;
    public $timerStarted = false;
    public $rem = '';
    public $tracker = null;

    protected $listeners = ['openTacker'];

    public function mount(){
        $this->showModal = false;
        $this->loadTrackerProperties();
    }

    public function loadTrackerProperties(){
        $this->tracker = $this->getTracking();

        if ($this->tracker) {
            $this->rem = $this->tracker->rem;
        } else {
            $this->reset('rem');
        }
    }

    public function openTacker($projectId)
    {
        $this->selectedProject = Project::findOrFail($projectId);
        $this->loadTrackerProperties();
        $this->showModal = true;
        $this->updateElapsedTime();
    }

    public function updated($property) {
        switch ($property) {
            case 'rem':
                    $this->saveRem();
                break;
        }
    }

    public function saveRem() {
        if ($this->tracker) {
            $this->tracker->update(['rem'=>$this->rem]);
        } else {
            $this->tracker = $this->selectedProject->trackings()->create(['rem'=>$this->rem]);
        }
    }

    public function getElapsedTimeFormattedProperty(){
        return gmdate("H:i:s", $this->elapsedTime);
    }

    public function startTimer()
    {
        if (!$this->tracker) {
            $now = now();
            $this->tracker = $this->selectedProject->trackings()->create(['start_at'=>$now]);

            $this->elapsedTime = 1;
            $this->timerStarted = true;
            $this->dispatch('timer-start',['elapsedTime'=>$this->elapsedTime]);
        }
    }

    public function stopTimer()
    {
        $startedTracking = $this->tracker;
        if ($startedTracking) {
            $startedTracking->update(['end_at'=>now()]);
            $this->elapsedTime = $startedTracking->duration_in_seconds;
            $this->dispatch('timer-stop');
            $this->reset(['tracker','rem','elapsedTime','timerStarted']);
        }


    }

    private function getTracking(){
        return $this->selectedProject?->trackings()->hasStarted()->first();
    }

    public function updateElapsedTime()
    {
        $startedTracking = $this->tracker;
        if ($startedTracking) {
            $this->elapsedTime = now()->diffInSeconds($startedTracking->start_at);
            $this->dispatch('timer-start',['elapsedTime'=>$this->elapsedTime]);
            $this->timerStarted = true;
        } else {
            $this->elapsedTime = 0;
            $this->timerStarted = false;
        }
    }

    public function render()
    {
        return view('livewire.time-tracker');
    }
}
