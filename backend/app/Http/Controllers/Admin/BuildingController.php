<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->paginate(10);
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:buildings,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $building = Building::create($request->only('name'));

        if ($request->hasFile('image')) {
            $building->addMediaFromRequest('image')->toMediaCollection('building_images');
        }

        return redirect()->route('admin.buildings.index')
                         ->with('success', 'Gedung baru berhasil ditambahkan.');
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('buildings')->ignore($building->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $building->update($request->only('name'));

        if ($request->hasFile('image')) {
            $building->addMediaFromRequest('image')->toMediaCollection('building_images');
        }

        return redirect()->route('admin.buildings.index')
                         ->with('success', 'Data gedung berhasil diperbarui.');
    }

    public function destroy(Building $building)
    {
        // Prevent deletion if the building is in use by tenants
        if ($building->tenants()->exists()) {
            return back()->with('error', 'Gedung tidak dapat dihapus karena masih digunakan oleh tenant.');
        }

        $building->delete();

        return redirect()->route('admin.buildings.index')
                         ->with('success', 'Gedung berhasil dihapus.');
    }
}