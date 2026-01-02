<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tracker;
use App\Models\TrackerType;

use function Symfony\Component\Clock\now;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $stats = [
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_coordinators' => User::where('role', 'coordinator')->count(),
            'total_submissions' => Tracker::count(),
            'pending_review' => User::where('role', 'pending')->count(),
        ];

        $recentTrackers = Tracker::with('user', 'trackerType')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats','recentTrackers'));

    }

    public function users()
    {
        $users = User::where('teachers', 'coordinators')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function tracker(){
        $trackers = Tracker::with(['user','trackerType','reviewer'])
        ->latest()
        ->paginate(15);

        return view('admin.trackers', compact('trackers'));
    }

    public function trackerTypes()
    {
        $trackerTypes = TrackerType::withCount('trackers')->get();

        return view('admin.tracker-types', compact('trackerTypes'));
    }

    public function assignCoordinator(Request $request){

        $validated = $request->validate([
            'teacher_id' => 'required|exists:user,id',
            'coordinator'=> 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($validated['teacher_id']);

        if(!$teacher->coordinators()->where('coordinator_id', $validated['coordinator_id'])->exists()){
                $teacher->coordinators()->attach($validated['coordinator_id'],
                [
                    'assigned_date' => now(),
                    'is_active' => true,
                ]);

                return back()->with('success','Coordinator assigned successfully');

        }
    }
}
