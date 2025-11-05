<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(){
        return "Daftar Lowongan Kerja";
    }

    public function admin(){
        $user = Auth::user();
        return "Halaman Admin ($user->name - $user->role)";
    }

    public function adminJobs(){
        $user = Auth::user();
        return "Halaman Admin Jobs ($user->name - $user->role)";
    }
}
