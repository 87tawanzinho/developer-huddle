<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
class ProjectController extends Controller
{
    //
    public function index(Request $request) {
       
        $projects = $request->user()->projects;
   
        $invitations = Invitation::where('email', $request->user()->email)->where('status', 'pending')->get();
        return Inertia::render("Welcome", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            "projects" => $projects,
            'user' => $request->user(),
            'invitations' => $invitations,
        ]);
    }

    public function show($id) { 
        $project = Project::findOrFail($id);
        return Inertia::render("InProject", [
         "id" => $id,
         "project" => $project,
        ]);
    }

    public function create(Request $request,) {
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "start_date" => "required",
            "end_date" => "required",
            "image" => "image",
        ]);

        $project = new Project();
        $project->name = $request->input('name');
        $project->owner = $request->user()->name; 
        $project->description = $request->input('description');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');

        if ($request->hasFile('image')) {
            $project->image = $request->file('image')->store('images', 'public');
        }

        $project->save();
        $request->user()->projects()->attach($project->id);

        return redirect()->route('/')->with('message', 'Project created successfully');
    }

    public function delete($id) {
        $project = Project::findOrFail($id); 
        $project->delete();
        return  redirect()->route('/')->with('message', 'Project deleted successfully');
    }
}
