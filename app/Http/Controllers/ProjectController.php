<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
class ProjectController extends Controller
{
    //
    public function index(Request $request) {
       
        $projects = $request->user()->projects;

        return Inertia::render("Welcome", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            "projects" => $projects
        ]);
    }

    public function show($id) { 
        return $id;
    }
}
