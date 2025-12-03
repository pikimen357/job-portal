<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationExport;
use App\Jobs\SendApplicationMailJob;
use App\Mail\ApplicationAcceptedMail;
use App\Mail\ApplicationRejectedMail;
use App\Mail\JobAppliedMail;
use App\Models\Application;
use App\Models\JobVacancy;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, JobVacancy $jobVacancy = null)
    {
        $query = Application::with(['user', 'job']);

        if ($jobVacancy) {
            $query->where('job_id', $jobVacancy->id);
        } elseif ($request->has('job_id') && $request->job_id) {
            $query->where('job_id', $request->job_id);
        }

        $applications = $query->get();
        $jobs = JobVacancy::all();

        return view('jobs.applicants', compact('applications', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);

        try {
            $job = $application->job;

            // Kirim email dengan CV path
            dispatch(new SendApplicationMailJob($job, auth()->user(), $cvPath));

            \Log::info('Email berhasil dikirim ke: ' . auth()->user()->email);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email: ' . $e->getMessage());
        }

        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new NewApplicationNotification($application));
                \Log::info('Notifikasi berhasil dikirim ke admin');
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi: ' . $e->getMessage());
        }

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Update status to Accepted
     */
    public function accept($id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);

        // Update status
        $application->update([
            'status' => 'Accepted'
        ]);

        // Kirim email ke pelamar
        try {
            Mail::to($application->user->email)
                ->send(new ApplicationAcceptedMail($application));

            \Log::info('Email accepted berhasil dikirim ke: ' . $application->user->email);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email accepted: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Lamaran diterima dan email notifikasi telah dikirim ke ' . $application->user->name);
    }

    /**
     * Update status to Rejected
     */
    public function reject($id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);

        // Update status
        $application->update([
            'status' => 'Rejected'
        ]);

        // Kirim email ke pelamar
        try {
            Mail::to($application->user->email)
                ->send(new ApplicationRejectedMail($application));

            \Log::info('Email rejected berhasil dikirim ke: ' . $application->user->email);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email rejected: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Lamaran ditolak dan email notifikasi telah dikirim ke ' . $application->user->name);
    }

    /**
     * Update the specified resource in storage (Legacy support).
     */
    public function update(Request $request, string $id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);

        $oldStatus = $application->status;
        $newStatus = $request->input('status', 'Accepted');

        $application->update([
            'status' => $newStatus
        ]);

        // Kirim email jika status berubah
        if ($oldStatus !== $newStatus) {
            try {
                if ($newStatus === 'Accepted') {
                    Mail::to($application->user->email)
                        ->send(new ApplicationAcceptedMail($application));
                } elseif ($newStatus === 'Rejected') {
                    Mail::to($application->user->email)
                        ->send(new ApplicationRejectedMail($application));
                }

                \Log::info('Email status berhasil dikirim ke: ' . $application->user->email);
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email status: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Status aplikasi berhasil diperbarui dan email telah dikirim.');
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
        return Excel::download(new ApplicationExport, 'applications.xlsx');
    }

    // Export pelamar berdasarkan lowongan
    public function exportByJob($jobId)
    {
        $job = JobVacancy::findOrFail($jobId);
        $fileName = 'pelamar-' . str_replace(' ', '-', strtolower($job->title)) . '.xlsx';

        return Excel::download(new ApplicationExport($jobId), $fileName);
    }
}
