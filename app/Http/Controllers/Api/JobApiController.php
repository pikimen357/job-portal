<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/jobs",
     *   summary="Get all job listings",
     *   tags={"Jobs"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="List of jobs",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="title", type="string"),
     *         @OA\Property(property="company", type="string"),
     *         @OA\Property(property="location", type="string")
     *       )
     *     )
     *   )
     * )
     */
    public function index(Request $req)
    {
        $q = Job::query();

        // Filter keyword
        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function ($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }

        // Pagination default 10
        $jobs = $q->orderBy('created_at', 'desc')
                  ->paginate($req->get('per_page', 10));

        return response()->json($jobs);
    }

    /**
     * Detail 1 job
     */
    public function show(Job $job)
    {
        return response()->json($job);
    }

    /**
     * Membuat job (hanya admin)
     */
    public function store(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'location'    => 'required|string',
            'company'     => 'required|string',
            'salary'      => 'nullable|integer',
        ]);

        $job = Job::create($data);

        return response()->json([
            'message' => 'Created',
            'job'     => $job
        ], 201);
    }

    /**
     * Update job (hanya admin)
     */
    public function update(Request $req, Job $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title'       => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'location'    => 'sometimes|required|string',
            'company'     => 'sometimes|required|string',
            'salary'      => 'nullable|integer',
        ]);

        $job->update($data);

        return response()->json([
            'message' => 'Updated',
            'job'     => $job
        ]);
    }

    /**
     * Hapus job (hanya admin)
     */
    public function destroy(Request $req, Job $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $job->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
