<?php
namespace App\Http\Controllers;

use App\Models\Tracker;
use App\Models\TrackerType;
use function Symfony\Component\Clock\now;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $trackers = auth()->user()->trackers()
            ->with('trackerTypes')
            ->latest()
            ->paginate(10);

        $trackerTypes = TrackerType::where('is_active', true)->get();

        return view('trackers.index', compact('trackers', 'trackerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $trackerTypes = TrackerType::where('is_active', true)->get();

        return view('trackers.create', compact('trackersTypes'));
        return view('trackers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = $request->validate([
            'tracker_type_id' => 'required|exists:tracker_types,id',
            'file'            => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'period_start'    => 'required|date',
            'period_end'      => 'required|date|after_or_equal:period_start',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $file     = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path     = $file->storeAs('trackers', $filename, 'public');

        Tracker::create([
            'user_id'           => auth()->id(),
            'tracker_type_id'   => $validated['tracker_type_id'],
            'file_path'         => $path,
            'original_filename' => $file->getClientOriginalName(),
            'submission_date'   => now(),
            'period_start'      => $validated['period_start'],
            'period_end'        => $validated['period_end'],
            'notes'             => $validated['notes'],
            'status'            => 'pending',
        ]);

        return redirect()->route('trackers.index')
            ->with('success', 'Tracker submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tracker $tracker)
    {
        //

        Gate::authorize('view', $tracker);

        $trackerTypes = TrackerType::where('is_active', true)->get();

        return view('trackers.show', compact('tracker', 'trackerTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tracker $tracker)
    {
        //
        Gate::authorize('update', $tracker);

        $trackerTypes = TrackerType::where('is_active', true)->get();

        return view('treckers.edit', compact('tracker', 'trackerTypes'));

    }

    public function download(Tracker $tracker)
    {
        Gate::authorize('view', $tracker);

        if (! Storage::disk('public')->exists($tracker->file_path)) {
            abort(404, 'File not found');

        }

        $extension = pathinfo($tracker->file_path, PATHINFO_EXTENSION);

        $previewableExtensions = ['pdf'];

        if (in_array(strtolower($extension), $previewableExtensions)) {

            return response()->file(
                Storage::disk('public')->path($tracker->file_path),
                [
                    'Content-Type'        => Storage::disk('public')->mimeType($tracker->file_path),
                    'Content-Disposition' => 'inline; filename="' . $tracker->original_filename . '"'
                ]
            );
        } else {
            return Storage::disk('public')->download($tracker->file_path, $tracker->original_filename);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tracker $tracker)
    {
        //

        Gate::authorize('update', $tracker);

        $validated = $request->validate([
            'tracker_type_id' => 'required|exists:tracker_types, id',
            'file'            => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'period_start'    => 'required|date',
            'period_end'      => 'required|date|after_or_equal:period_start',
            'notes'           => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('file')) {

            // Delete the old file

            Storage::disk('private')->delete($tracker->file_path);

            // Store new file

            $file     = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs('trackers', $filename, 'private');

            $validated['file_path']         = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $tracker->update($validated);

        return redirect()->route('trackers.index')->with('success', 'Tracker Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracker $tracker)
    {
        //

        Gate::authorize('delete', $tracker);

        Storage::disk('public')->delete($tracker->file_path);

        $tracker->delete();

        return redirect()->route('trackers.index')->with('success', 'Tracker deleted successfully');

    }
}
