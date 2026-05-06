<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CableProvider;
use App\Models\CablePlan;

class CableManagementController extends Controller {

    /**
     * List all active providers and their active plans.
     */
    public function index() {
        return CableProvider::with('plans')->get();
    }

    /**
     * Fetch soft-deleted records (Trash).
     * Usage: /admin/cable/trashed/provider OR /admin/cable/trashed/plan
     */
    public function trashed($type = 'provider') {
        if ($type === 'plan') {
            return CablePlan::onlyTrashed()->with('provider')->get();
        }
        return CableProvider::onlyTrashed()->get();
    }

    /**
     * Restore a soft-deleted record.
     */
    public function restore($id, $type = 'provider') {
        $item = ($type === 'plan')
            ? CablePlan::onlyTrashed()->findOrFail($id)
            : CableProvider::onlyTrashed()->findOrFail($id);

        $item->restore();

        return response()->json(['message' => ucfirst($type) . ' restored successfully']);
    }

    /**
     * Toggle Provider Status (CASCADING).
     */
    public function toggleStatus($id) {
        $provider = CableProvider::findOrFail($id);
        $newStatus = !$provider->is_active;
        $provider->update(['is_active' => $newStatus]);

        // Cascade status to all associated plans
        CablePlan::where('cable_provider_id', $id)->update(['is_active' => $newStatus]);

        return response()->json(['message' => 'Status updated', 'is_active' => $newStatus]);
    }

    /**
     * Toggle Individual Plan Status.
     */
    public function togglePlanStatus($id) {
        $plan = CablePlan::findOrFail($id);
        $plan->update(['is_active' => !$plan->is_active]);
        return response()->json(['message' => 'Plan updated', 'is_active' => $plan->is_active]);
    }

    /**
     * Store/Update Provider.
     */
    public function storeProvider(Request $request) {
        return CableProvider::create($request->all());
    }

    public function updateProvider(Request $request, $id) {
        $provider = CableProvider::findOrFail($id);
        $provider->update($request->all());
        return response()->json(['message' => 'Provider updated']);
    }

    /**
     * Soft Delete Provider (CASCADING).
     */
    public function destroyProvider($id) {
        $provider = CableProvider::findOrFail($id);
        // Soft delete all plans belonging to this provider first
        CablePlan::where('cable_provider_id', $id)->delete();
        $provider->delete();
        return response()->json(['message' => 'Provider and its plans moved to trash']);
    }

    /**
     * Plan CRUD.
     */
    public function storePlan(Request $request) {
        return CablePlan::create($request->all());
    }

    public function updatePlan(Request $request, $id) {
        $plan = CablePlan::findOrFail($id);
        $plan->update($request->validate([
            'plan_name' => 'required|string',
            'plan_id'   => 'required',
            'price'     => 'required|numeric',
            'validity'  => 'nullable|string',
        ]));
        return response()->json(['message' => 'Plan updated']);
    }

    public function destroyPlan($id) {
        CablePlan::findOrFail($id)->delete();
        return response()->json(['message' => 'Plan moved to trash']);
    }
}
