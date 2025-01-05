<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    #TODO: adicionar role ao convite
    public function store(Request $request)
    {
        // Validação do email
        $validated = $request->validate([
            'username' => 'required|exists:users,username',
            'project_id' => 'required|exists:projects,id',
        ],[
            'username.exists' => 'User not found',
            'project_id.exists' => 'Project not found',
        ]);

        $user = User::where('username', $validated['username'])->first();
        $project = Project::find($validated['project_id']);

        if ($user && $project->users()->wherePivot('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'User already in project'], 422);
        }

        Invitation::create([
            'invited_id' => $user->id,
            'project_id' => $project->id,
            'owner_id' => $request->user()->id,
            'role' => 'member',
            'expires_at' => now()->addMonth(),
        ]);

        return back()->with('success', 'Convite enviado com sucesso!');
    }

    public function updateInvite(Request $request)
    {
        $validated = $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'status' => 'required|in:accepted,rejected',
        ]);

        $user = $request->user();
        $invitation = $user->invitations()->findOrfail($validated['invitation_id']);

        $invitation->update([
            'status' => $validated['status'],
        ]);

        if($validated['status'] == 'accepted') {
            $project = $invitation->project;
            if($project->users()->wherePivot('user_id', $user->id)->exists()) {
                return redirect()->back();
            }
            $project->users()->attach($user->id, ['role' => $invitation->role]);
        }


        return redirect()->back();
    }

}
