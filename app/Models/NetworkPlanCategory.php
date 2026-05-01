<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlanCategory;
use App\Models\AvailableDataPlan;

class NetworkPlanCategory extends Model
{
    protected $fillable = [
        'name',
        'plan_category_id',
        "active"
    ];

    public function planCategory()
    {
        return $this->belongsTo(PlanCategory::class, 'plan_category_id');
    }

    public function dataPlans()
    {
        return $this->hasMany(AvailableDataPlan::class, 'network_plan_category_id');
    }
}
