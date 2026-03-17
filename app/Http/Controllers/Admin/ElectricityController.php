<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElectricityProvider;
use Illuminate\Http\Request;

class ElectricityController extends Controller
{

    // GET ALL PROVIDERS
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => ElectricityProvider::latest()->get()
        ]);
    }

    // CREATE PROVIDER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:electricity_providers'
        ]);

        $provider = ElectricityProvider::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => true
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Provider created successfully',
            'data' => $provider
        ]);
    }

    // UPDATE PROVIDER
    public function update(Request $request, $id)
    {
        $provider = ElectricityProvider::findOrFail($id);

        $provider->update([
            'name' => $request->name,
            'code' => $request->code
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Provider updated',
            'data' => $provider
        ]);
    }

    // TOGGLE STATUS
    public function toggle($id)
    {
        $provider = ElectricityProvider::findOrFail($id);

        $provider->status = !$provider->status;
        $provider->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated',
            'data' => $provider
        ]);
    }

    // SOFT DELETE
    public function destroy($id)
    {
        $provider = ElectricityProvider::findOrFail($id);
        $provider->delete();

        return response()->json([
            'status' => true,
            'message' => 'Provider deleted'
        ]);
    }
}
