<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'count_projects',
        'count_users_project',
        'count_admin_project',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
