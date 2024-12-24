<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function store(Request $request)
    {
        // Validação do email
        $validated = $request->validate([
            'email' => 'required|email',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Encontrando o usuário pelo email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User not found');
        }

        // Encontrando o projeto
        $project = Project::find($validated['project_id']);
        // Verificando se o usuário já é membro do projeto
        if ($user && $project->users()->wherePivot('user_id', $user->id)->exists()) {
            return back()->with('error', 'User is already a member of this project');
        }

        // Gerando token
        $token = Str::random(32);

        // Criando o convite na tabela de 'invitations'
        Invitation::create([
            'project_id' => $project->id,
            'email' => $validated['email'],
            'token' => $token,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

     

        return back()->with('success', 'Convite enviado com sucesso!');
    }
}
