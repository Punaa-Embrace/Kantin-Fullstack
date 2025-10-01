<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
     public function index(Request $request)
    {
        $categories = Category::whereHas('menuItems')->get();

        $menuItemQuery = MenuItem::where('is_available', true)
                                  ->with(['tenant.building', 'categories']);

        if ($request->has('category') && $request->category !== 'all') {
            $menuItemQuery->whereHas('categories', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $menuItemQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                      ->orWhereHas('tenant', function ($q) use ($searchTerm) {
                          $q->where('name', 'like', "%{$searchTerm}%");
                      });
            });
        }

        $menuItems = $menuItemQuery->latest()->paginate(12)->withQueryString();

        return view('student.menus.index', compact('categories', 'menuItems'));
    }
}
