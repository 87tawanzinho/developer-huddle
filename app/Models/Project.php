<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
            "name",
            "description",
            'owner',
            "start_date",
            "end_date",
            "image",
    ];

    // um projeto pertence a muitos usuarios
    public function users() {
        return $this->belongsToMany(User::class, 'users_projects');
    }


    // um projeto possui muitos convites
    public function invitations() {
        return $this->hasMany(Invitation::class);
    }
}
