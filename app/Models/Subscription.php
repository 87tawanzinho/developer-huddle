<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model

 
{

        use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_id',
        'gateway_id',
        'status',
        'canceled_at',
    ];

    protected $with = ['plan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
