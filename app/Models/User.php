<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    public function assemblies(): BelongsToMany
    {
        return $this->belongsToMany(Assembly::class);
    }
}
