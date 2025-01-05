<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index() {
        return Inertia::render("LandingPage");
    }

    public function home()
    {
        $user = Auth::user();
        $projects = $user->projects->load(['users','owner'])->toArray();
        $invitations = $user->invitations->where('status', 'pending')->load(['owner','project'])->toArray();

        return Inertia::render("Welcome", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'projects' => $projects,
            'user' => $user,
            'invitations' => $invitations,
        ]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $users = $project->users;
        return Inertia::render("InProject", [
            "id" => $id,
            "project" => $project->load(['tasks','owner'])->toArray(),
            'users' => $users,
            'tasks' => $project->tasks->load(['responsible'])->toArray(),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "start_date" => "required",
            "end_date" => "required",
            "image" => "image",
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'cover_path' => $request->file('image')->store('images/projects'),
        ]);
        $project->users()->attach($request->user()->id, ['role' => 'owner']);

        return redirect()->back();
    }

    public function createTask(Request $request)
    {
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

    public function deleteTask(Request $request)
    {
        $task = Task::findOrFail($request->id);

        $task->delete();

        return redirect()->back();
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/');
    }

    public function updateTaskDescription(Request $request, $projectId, $taskId)
    {
        {
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
