<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Event\Tracer\Tracer;

use function Symfony\Component\String\u;

class CoordinatorController extends Controller
{
    //
    public function dashboard(){

        $user = auth()->user();

        $teacherIds = $user->teachers()->pluck('users.id');

        $stats = [
            'total_teachers' => $user->teachers()->count(),
            'total_submissions' => Tracker::whereIn('user_id', $teacherIds)->count(),
            'pending_review' => Tracker::whereIn('user_id', $teacherIds)->where('status', 'pending')->count(),
            'reviewed' => Tracker::whereIn('user_id', $teacherIds)->where('status', 'reviewed')->count(),
        ];

        $recentTrackers = Tracker::whereIn('user_id', $teacherIds)
                ->with('user', 'trackerType')
                ->latest()
                ->take(10)
                ->get();


        return view('coordinator.dashboard', compact('stats', 'recentTrackers'));

    }

    public function trackers(){
        $teacherIds = auth()->user()->teachers()->pluck('user.id');

        $trackers = Tracker::whereIn('user_id', $teacherIds)
        ->with('user','trackerType')
        ->latest()
        ->paginate(15);

        return view('coordinator.trackers', compact('trackers'));
    }

    public function review(Request $request, Tracker $tracker){

        Gate::authorize('review', $tracker);

        $validated = $request->validate([
            'status' => 'required|in:reviewed,rejected',
            'coordinator_notes' => 'nullable|string|max:1000',
        ]);

        $tracker->update([
            'status'=> $validated['status'],
            'coordinator' => $validated['coordinator_notes'],
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);


        return back()->with('success','Tracker reviewed successfully!');
        

    }
}
