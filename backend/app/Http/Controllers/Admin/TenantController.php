<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['manager', 'building'])->latest()->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $managers = User::where('role', 'tenant_manager')->whereDoesntHave('tenant')->pluck('name', 'id');
        $buildings = Building::pluck('name', 'id');
        return view('admin.tenants.create', compact('managers', 'buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tenants',
            'user_id' => 'required|exists:users,id|unique:tenants,user_id',
            'building_id' => 'required|exists:buildings,id',
            'description' => 'nullable|string',
            'is_open' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant = Tenant::create($request->all() + ['slug' => Str::slug($request->name)]);

        if ($request->hasFile('photo')) {
            $tenant->addMediaFromRequest('photo')->toMediaCollection('photo');
        }
        if ($request->hasFile('qris')) {
            $tenant->addMediaFromRequest('qris')->toMediaCollection('qris');
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Stand baru berhasil ditambahkan.');
    }

    public function edit(Tenant $tenant)
    {
        $unassignedManagers = User::where('role', 'tenant_manager')->whereDoesntHave('tenant')->pluck('name', 'id');
        $currentManager = User::where('id', $tenant->user_id)->pluck('name', 'id');
        $managers = $unassignedManagers->union($currentManager);
        
        $buildings = Building::pluck('name', 'id');

        return view('admin.tenants.edit', compact('tenant', 'managers', 'buildings'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'user_id' => ['required', 'exists:users,id', Rule::unique('tenants')->ignore($tenant->id)],
            'building_id' => 'required|exists:buildings,id',
            'description' => 'nullable|string',
            'is_open' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'qris' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant->update($request->all() + ['slug' => Str::slug($request->name)]);

        if ($request->hasFile('photo')) {
            $tenant->addMediaFromRequest('photo')->toMediaCollection('photo');
        }
        if ($request->hasFile('qris')) {
            $tenant->addMediaFromRequest('qris')->toMediaCollection('qris');
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Data stand berhasil diperbarui.');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->orders()->exists()) {
            return back()->with('error', 'Stand tidak dapat dihapus karena memiliki riwayat pesanan.');
        }

        $tenant->delete(); 

        return redirect()->route('admin.tenants.index')->with('success', 'Stand berhasil dihapus.');
    }
}