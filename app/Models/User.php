<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        "phone",
        'email',
        'password',
        'is_admin',
    ];

    /**
     * Hidden attributes when returning JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * RELATIONSHIP
     * A user has one wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * RELATIONSHIP
     * A user has many transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Automatically create a wallet
     * whenever a new user is registered
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->wallet()->create([
                'balance' => 0
            ]);
        });
    }
}
