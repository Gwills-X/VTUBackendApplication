<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',
        'type',   // e.g., 'wallet_fund', 'airtime', 'data', 'electricity'
        'amount',
        'status',  // e.g., 'pending', 'completed', 'failed'
        "phone_number",
        'reference',
        "meta"
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'amount' => 'float',
        'meta' => 'array'
    ];

    /**
     * RELATIONSHIP: Transaction belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
