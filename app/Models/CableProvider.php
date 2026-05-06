<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CableProvider extends Model {
    use SoftDeletes;
    protected $fillable = ['name', 'api_id', 'is_active'];

    public function plans() {
        return $this->hasMany(CablePlan::class);
    }
}
