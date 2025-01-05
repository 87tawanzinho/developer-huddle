<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects->load(['users','owner'])->toArray();
        $invitations = $user->invitations->where('status', 'pending')->load(['owner','project'])->toArray();

        return Inertia::render('Projects/List', [
            'projects' => $projects,
            'user' => $user,
            'invitations' => $invitations,
        ]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $users = $project->users;
        return Inertia::render("Projects/Show", [
            "project" => $project->load(['tasks','owner'])->toArray(),
            'users' => $users,
            'tasks' => $project->tasks->load(['responsible'])->toArray(),
        ]);
    }

    public function store(Request $request)
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
            "responsible_id" => "required|integer|max:255",
            "status" => "required|string|max:255",
            "progress" => "required|integer|min:0|max:100",
            "project_id" => "required|exists:projects,id",
        ]);


        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->responsible_id = $request->responsible_id;
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

    public function updateTask(Request $request, $projectId, $taskId)
    {
        {
            $request->validate([
                "description" => "nullable|string",
                "title" => "nullable|string",
                "status" => "nullable",
                "responsible" => "nullable",
                "priority" => "nullable",
                "progress" => "nullable",
            ]);


            $task = Task::where('project_id', $projectId)->findOrFail($taskId);
            $task->description = $request->input('description', $task->description);
            $task->progress = $request->input('progress', $task->progress);
            $task->responsible_id = $request->input('responsible_id', $task->responsible_id);
            $task->save();

            return redirect()->back();
        }
    }
}
