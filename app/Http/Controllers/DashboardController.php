<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackerType;

class DashboardController extends Controller
{
    //

    public function teacher(){
        $user = auth()->user();

        $stats = [
            'total_submissions' => $user->trackers()->count(),
            'pending' => $user->trackers()->where('status', 'pending')->count(),
            'reviewed' => $user->trackers()->where('status', 'reviewed')->count(),
            'rejected' => $user->trackers()->where('status', 'rejected')->count(),
        ];


        $recentTrackers = $user->trackers()
        ->with('trackerTypes')
        ->latest()
        ->take(5)
        ->get();

         $trackerTypes = TrackerType::where('is_active', true)->get();
        $coordinators = $user->coordinators();

        return view('teacher.dashboard', compact('stats','recentTrackers','coordinators', 'trackerTypes'));
    }
}
