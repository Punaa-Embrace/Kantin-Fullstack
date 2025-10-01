<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page with dynamic data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recommendedMenus = MenuItem::with(['tenant.building'])
            ->where('is_available', true)
            ->inRandomOrder(date('Y-m-d'))
            ->take(3)
            ->get();
            
        $buildings = Building::whereHas('tenants')->get();

        return view('welcome', compact('recommendedMenus', 'buildings'));
    }
}
