<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobVacancyRequest;
use App\Http\Requests\UpdateJobVacancyRequest;
use App\Imports\JobsImport;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobVacancy::all();
        $isAdmin = auth()->user()->role === 'admin'; // atau sesuai dengan sistem role Anda
        return view('jobs.index', compact('jobs', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobVacancyRequest $request)
    {
        $validated = $request->validated();

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        JobVacancy::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'company' => $validated['company'],
            'salary' => $validated['salary'] ?? null,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacancy $jobVacancy)
    {
        return view('jobs.show', ['job' => $jobVacancy]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        return view('jobs.edit', ['job' => $jobVacancy]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateJobVacancyRequest $request,
        JobVacancy $jobVacancy
    )    {
        $validated = $request->validated();

        // Cek apakah ada upload logo baru
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $jobVacancy->update($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan kerja berhasil dihapus.');
    }

    public function import(Request $request)
    {

        $request->validate(['file' =>
            'required|mimes:xlsx,csv']);

        Excel::import(new JobsImport(), $request->file('file'));

        return back()->with('success', 'Data lowongan
            berhasil diimport');
        }
}
