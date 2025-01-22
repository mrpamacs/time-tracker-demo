<?php

namespace App\Livewire;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\TimeTracking;

class ProjectExport extends Component {
    use Toast;

    public $dateFrom;
    public $dateTo;

    protected $listeners = ['exportCompleted'];

    public function mount() {
        $this->dateFrom = Carbon::now()->subWeek();
        $this->dateTo = Carbon::now();
    }

    public function export() {

        $this->toast('warning', 'Az exportálás elindult!');

        return response()->streamDownload(function () {
            $data = [
                ['Name' => 'John Doe', 'Email' => 'xxx'],
                ['Name' => 'Jane Smith', 'Email' => 'yyyy'],
            ];

            $trackings = TimeTracking::loggedUser()->select(DB::raw('SUM(TIMESTAMPDIFF(SECOND, start_at, end_at)) as duration, time_trackings.project_id'))->dateFilter($this->dateFrom, $this->dateTo)->groupBy('project_id');

            $totals = Project::query()
                ->leftJoinSub($trackings,'time_trackings',function($join){
                    $join->on('time_trackings.project_id', '=', 'projects.id');
                })
                ->select('projects.*', 'time_trackings.duration')
                ->groupBy('projects.id')->get();

            $timeTrackings = TimeTracking::loggedUser()->dateFilter($this->dateFrom, $this->dateTo)->get();



            $pdf = Pdf::loadView('export.time-tracking', ['from' => $this->dateFrom, 'to' => $this->dateTo, 'data' => $data, 'totals' => $totals, 'timeTrackings'=>$timeTrackings]);
            echo $pdf->output();
        }, 'exported-data-' . time() . '.pdf');
    }

    public function render() {
        return view('livewire.project-export');
    }
}
