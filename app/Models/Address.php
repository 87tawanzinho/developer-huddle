<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $fillable = [
        'street',
        'number',
        'complement',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    protected $casts = [
        'number' => 'integer'
    ];

    public function user(): hasOne
    {
        return $this->hasOne(User::class);
    }
}
