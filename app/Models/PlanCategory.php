<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AvailableDataPlan;
use App\Models\NetworkPlanCategory;

class PlanCategory extends Model
{
    protected $fillable = ['name','active'];

    public function plans()
    {
        return $this->hasMany(AvailableDataPlan::class, 'plan_category_id');
    }

    public function networkCategories()
    {
        return $this->hasMany(NetworkPlanCategory::class, 'plan_category_id');
    }
}
