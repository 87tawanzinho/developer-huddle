<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'likes'
    ]; 


    public function task(): BelongsTo {
        return $this->belongsTo(Task::class);
    }

    public function responsible(): BelongsTo {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
