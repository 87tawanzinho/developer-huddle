<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'responsible',
        'status',
        'progress',
        'project_id'
    ];

    public function projects() {
        return $this->belongsTo(Project::class);
    }
}
