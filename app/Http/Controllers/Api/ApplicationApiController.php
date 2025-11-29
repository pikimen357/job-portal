<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $apps = Application::with(['user', 'job'])
                ->latest()
                ->paginate($request->query('per_page', 10));

        return response()->json($apps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Job Seeker apply (upload CV via API)
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $app = Application::create([
            'user_id' => $request->user()->id,
            'job_id' => $request->job_id,
            'cv' => $cvPath,
            'status' => 'Pending'
        ]);

        return response()->json([
                "message" => "Application submitted",
                "application" => $app]
            , 201);
    }
}
