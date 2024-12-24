<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'email',
        'token',
        'status',
        'expires_at',
        'project_name',
        'project_description',
        'start_date',
        'end_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
