<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',
        'balance'
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'balance' => 'float',
    ];

    /**
     * RELATIONSHIP: Wallet belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
