<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'tenant_manager':
                return $this->tenantDashboard();
            case 'student':
            default:
                return $this->studentDashboard();
        }
    }

    private function studentDashboard()
    {
        // $categories = Category::take(8)->get();
        $categories = Category::whereHas('menuItems')->take(8)->get();

        $famousMenuItems = MenuItem::with(['tenant.building', 'categories'])
            ->where('is_available', true)
            ->latest()
            ->take(4)
            ->get();


        $recommendedMenuItems = MenuItem::with(['tenant.building', 'categories'])
            ->where('is_available', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('student.dashboard', compact('categories', 'famousMenuItems', 'recommendedMenuItems'));
    }

    private function adminDashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalTenants' => Tenant::count(),
            'totalCompletedOrders' => Order::where('order_status', 'completed')->count(),
            'totalRevenue' => Order::where('order_status', 'completed')->sum('total_price'),
        ];

        $recentOrders = Order::with(['student', 'tenant'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }

    /**
     * Prepare and return the view for the tenant manager's dashboard.
     */
    private function tenantDashboard()
    {
        $user = Auth::user();

        if (!$user->tenant) {
            return view('tenant.unassigned');
        }

        $tenantId = $user->tenant->id;

        // --- Date Ranges ---
        $currentPeriodStart = now()->subDays(30);
        $currentPeriodEnd = now();
        $previousPeriodStart = now()->subDays(60);
        $previousPeriodEnd = now()->subDays(30);

        // --- Current Period Stats ---
        $currentTotalOrders = Order::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
            ->count();

        $currentCancelledOrders = Order::where('tenant_id', $tenantId)
            ->where('order_status', 'rejected')
            ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
            ->count();

        $currentRevenue = Order::where('tenant_id', $tenantId)
            ->where('order_status', 'completed')
            ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
            ->sum('total_price');

        // --- Previous Period Stats ---
        $previousTotalOrders = Order::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->count();

        $previousCancelledOrders = Order::where('tenant_id', $tenantId)
            ->where('order_status', 'rejected')
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->count();

        $previousRevenue = Order::where('tenant_id', $tenantId)
            ->where('order_status', 'completed')
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->sum('total_price');

        // --- Percentage Change Calculations ---
        $totalOrdersChange = $this->calculatePercentageChange($previousTotalOrders, $currentTotalOrders);
        $cancelledOrdersChange = $this->calculatePercentageChange($previousCancelledOrders, $currentCancelledOrders);
        $revenueChange = $this->calculatePercentageChange($previousRevenue, $currentRevenue);

        // --- Recent Orders ---
        $recentOrders = Order::where('tenant_id', $tenantId)
            ->with('student')
            ->latest()
            ->take(5)
            ->get();

        return view('tenant.dashboard', compact(
            'currentTotalOrders',
            'currentCancelledOrders',
            'currentRevenue',
            'totalOrdersChange',
            'cancelledOrdersChange',
            'revenueChange',
            'recentOrders'
        ));
    }

    /**
     * Helper to calculate percentage change.
     */
    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
