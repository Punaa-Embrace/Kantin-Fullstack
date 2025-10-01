<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class MenuItemController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant->id ?? null;
    }

    public function index()
    {
        $menuItems = MenuItem::where('tenant_id', $this->getTenantId())
                               ->with('categories')
                               ->latest()
                               ->paginate(10);

        return view('tenant.menu_items.index', compact('menuItems'));
    }

    public function create()
    {
        $allCategories = Category::pluck('name')->toJson();
        return view('tenant.menu_items.create', compact('allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'categories' => 'required|json', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $menuItem = MenuItem::create($request->all() + ['tenant_id' => $this->getTenantId()]);
        
        $categoryIds = $this->processCategories($request->input('categories'));
        $menuItem->categories()->sync($categoryIds);

        if ($request->hasFile('photo')) {
            $menuItem->addMediaFromRequest('photo')->toMediaCollection('menu_item_photo');
        }

        return redirect()->route('tenant.menu-items.index')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function edit(MenuItem $menuItem)
    {
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403, 'AKSES DITOLAK');
        }

        $allCategories = Category::pluck('name')->toJson();
        $selectedCategories = $menuItem->categories->pluck('name')->toJson();

        return view('tenant.menu_items.edit', compact('menuItem', 'allCategories', 'selectedCategories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'categories' => 'required|json',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $menuItem->update($request->all());
        
        $categoryIds = $this->processCategories($request->input('categories'));
        $menuItem->categories()->sync($categoryIds);

        if ($request->hasFile('photo')) {
            $menuItem->addMediaFromRequest('photo')->toMediaCollection('menu_item_photo');
        }

        return redirect()->route('tenant.menu-items.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403);
        }

        $menuItem->delete();

        return redirect()->route('tenant.menu-items.index')->with('success', 'Menu berhasil dihapus.');
    }

    private function processCategories(string $jsonCategories): array
    {
        $categoryNames = collect(json_decode($jsonCategories))->pluck('value')->toArray();
        $categoryIds = [];

        foreach ($categoryNames as $categoryName) {
            $trimmedName = trim($categoryName);
            $category = Category::firstOrCreate(
                ['name' => $trimmedName],
                ['slug' => Str::slug($trimmedName)]
            );
            $categoryIds[] = $category->id;
        }

        return $categoryIds;
    }
}