<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class StudentTenantController extends Controller
{
    // ... existing web methods ...

    /**
     * API: Get all active tenants
     */
    public function apiIndex(Request $request)
    {
        try {
            $tenants = Tenant::where('is_active', true)
                ->with(['building', 'category'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tenants
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching tenants',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get tenant by slug
     */
    public function apiShow(Request $request, $slug)
    {
        try {
            $tenant = Tenant::where('slug', $slug)
                ->where('is_active', true)
                ->with(['building', 'category'])
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $tenant
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant not found'
            ], 404);
        }
    }
}