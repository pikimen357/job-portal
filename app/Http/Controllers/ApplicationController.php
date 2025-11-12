<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationExport;
use App\Models\Application;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $jobId)
    {
        $applications = Application::with('user',
            'job')->get();

        return view('applications.index',
            compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs',
            'public');

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);

        return back()->with('success', 'Lamaran berhasil
                            dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);
        $application->update([
            'status' => 'Accepted'
        ]);

        return redirect()->back()
            ->with('success', 'Status aplikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return redirect()->back()
            ->with('success', 'Aplikasi berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download (new ApplicationExport,
        'applications.xlsx');
    }
}
