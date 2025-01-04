<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
class ProjectController extends Controller
{
    //

    public function index() {
        return Inertia::render("House");
    }
    public function home(Request $request) {
       
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
        $users = $project->users;
        return Inertia::render("InProject", [
         "id" => $id,
         "project" => $project,
         'users' => $users,
         'tasks' => $project->tasks,
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

        return redirect()->back();
    }

    public function delete($id) {
        $project = Project::findOrFail($id); 
        $project->delete();
        return redirect('/');
    }

    public function createTask(Request $request) {
        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "priority" => "required|string",
            "responsible" => "required|string|max:255",
            "status" => "required|string|max:255",
            "progress" => "required|integer|min:0|max:100",
            "project_id" => "required|exists:projects,id",
        ]);


       
        $task = new Task(); 
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->responsible = $request->responsible;
        $task->progress = $request->progress;
        $task->project_id = $request->project_id;
        $task->save();

    return redirect()->back();
        
    }

    public function deleteTask(Request $request) {
        $task = Task::findOrFail($request->id);

        $task->delete();

        return redirect()->back();
    }

    public function updateTaskDescription(Request $request, $projectId, $taskId) { {
       $request->validate([
              "description" => "required|string",
         ]);

         $task = Task::where('project_id', $projectId)->findOrFail($taskId);
         $task->description = $request->description;
         $task->save();

         return redirect()->back();
    }
}
}
