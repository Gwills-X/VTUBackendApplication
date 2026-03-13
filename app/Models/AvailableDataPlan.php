<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PlanCategory;
use App\Models\NetworkPlanCategory;

class AvailableDataPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'network',
        'network_code',
        'plan_id',
        'data',
        'price',
        'validity',
        'plan_category_id',
        'network_plan_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(PlanCategory::class, 'plan_category_id');
    }

    public function networkCategory()
    {
        return $this->belongsTo(NetworkPlanCategory::class, 'network_plan_category_id');
    }
}
