<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'taskId' => 'required|exists:tasks,id', 
            'content' => 'required|string',
        ]);

        try {
            $task = Task::findOrFail($request->taskId);
            $comment = new Comment();
            $comment->content = $request->content;
            $task->comments()->save($comment); 
            $comment->responsible()->associate(Auth::user()); 
            $comment->save();

            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('Erro ao criar comentário: ' . $e->getMessage()); 
            return redirect()->back();
        }
    }

    public function liked(Request $request)
    {
        $validated = $request->validate([
            'commentId' => 'required|exists:comments,id',
        ]);
    
        $userId = Auth::id();
    
        if (!$userId) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }
    
        $existingLike = LikeComment::where('user_id', $userId)
            ->where('comment_id', $validated['commentId'])
            ->first();
    
        if ($existingLike) {
             $existingLike->delete();
             return redirect()->back(); 
        }
    
        LikeComment::create([
            'user_id' => $userId,
            'comment_id' => $validated['commentId'],
        ]);
    
        return redirect()->back();
    }
    
    
}
