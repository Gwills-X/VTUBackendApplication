<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CablePlan extends Model {
    use SoftDeletes;
    protected $fillable = ['cable_provider_id', 'plan_name', 'plan_id', 'price', 'validity', 'is_active'];

    public function provider() {
        return $this->belongsTo(CableProvider::class, 'cable_provider_id');
    }
}
