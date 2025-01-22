<?php

namespace App\Models;

use App\Observers\TimeTrackingObserver;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Auth;

#[ObservedBy([TimeTrackingObserver::class])]
class TimeTracking extends Model {
    protected $table = "time_trackings";

    protected $fillable = ['user_id','project_id', 'start_at', 'end_at', 'rem'];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at'   => 'datetime:Y-m-d H:i:s',
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function project() {
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function scopeHasStarted($query) {
        $query->whereNotNull('start_at')->whereNull('end_at');
    }

    public function getDurationInSecondsAttribute() {
        return ($this->start_at && $this->end_at) ? $this->end_at->diffInSeconds($this->start_at) : 0;
    }

    public function scopeLoggedUser($query,User $user = null){
        $user = $user ?? (Auth::check() ? Auth::user() : null);

        if ($user) {
            $query->where('user_id','=', $user->id);
        }
    }

    public function scopeDateFilter($query, $dateFrom = '', $dateTo = '') {
        $query->when($dateFrom, function ($query) use ($dateFrom) {
            $query->whereDate('start_at', '>=', Carbon::parse($dateFrom)->toDateString());
        })->when($dateTo, function ($query) use ($dateTo) {
            $query->whereDate('end_at', '<=', Carbon::parse($dateTo)->toDateString());
        });
    }
}