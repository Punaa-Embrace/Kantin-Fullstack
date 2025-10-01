<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $buildings = Building::whereHas('tenants')
            ->with(['tenants' => function ($query) {}])
            ->get();

        return view('student.tenants.index', compact('buildings'));
    }

    public function show(Tenant $tenant)
    {
        // Load only the available menu items for the given tenant, with pagination.
        $menuItems = $tenant->menuItems()
            ->where('is_available', true)
            ->with('categories') // Eager load categories if needed
            ->paginate(12); // Display 12 items per page

        return view('student.tenants.show', compact('tenant', 'menuItems'));
    }
}
