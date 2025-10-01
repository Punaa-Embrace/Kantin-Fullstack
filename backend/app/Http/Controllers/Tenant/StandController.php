<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StandController extends Controller
{
    /**
     * Show the form for editing the current tenant manager's stand.
     */
    public function edit()
    {
        // Get the authenticated user's tenant, or fail if they don't have one.
        $tenant = Auth::user()->tenant()->firstOrFail();
        
        $buildings = Building::pluck('name', 'id');
        
        return view('tenant.stand.edit', compact('tenant', 'buildings'));
    }

    /**
     * Update the specified stand in storage.
     */
    public function update(Request $request)
    {
        $tenant = Auth::user()->tenant()->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'building_id' => 'required|exists:buildings,id',
            'description' => 'nullable|string',
            'is_open' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'qris' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $tenant->update($request->all() + ['slug' => Str::slug($request->name)]);

        if ($request->hasFile('photo')) {
            $tenant->addMediaFromRequest('photo')->toMediaCollection('photo');
        }
        if ($request->hasFile('qris')) {
            $tenant->addMediaFromRequest('qris')->toMediaCollection('qris');
        }

        return redirect()->route('tenant.stand.edit')->with('success', 'Data stand Anda berhasil diperbarui.');
    }
}