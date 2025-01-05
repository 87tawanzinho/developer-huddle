<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'cpf_cnpj',
        'password',
        'address_id',
        'gateway_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'gateway_id',
        'address_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $with = ['subscription'];

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_projects')
            ->withPivot('role');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'invited_id');
    }

    public function invitationsSent(): HasMany
    {
        return $this->hasMany(Invitation::class, 'owner_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'responsible_id');
    }

    public function plan(): HasOneThrough
    {
        return $this->hasOneThrough(Plan::class, Subscription::class,
            'user_id', 'id', 'id', 'plan_id'
        );
    }
}
