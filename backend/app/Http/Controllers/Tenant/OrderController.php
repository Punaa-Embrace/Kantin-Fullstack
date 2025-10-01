<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant->id;
    }

    /**
     * Display a listing of the tenant's orders.
     */
    public function index()
    {
        $orders = Order::where('tenant_id', $this->getTenantId())
            ->with('student') // Eager load the student relationship
            ->latest()
            ->paginate(15);

        return view('tenant.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Security check: ensure the order belongs to the tenant
        if ($order->tenant_id !== $this->getTenantId()) {
            abort(403);
        }

        $order->load(['items', 'student']); // Eager load items and student

        return view('tenant.orders.show', compact('order'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        if ($order->tenant_id !== $this->getTenantId()) {
            abort(403);
        }

        $validated = $request->validate([
            'order_status' => ['nullable', Rule::in(['pending_approval', 'rejected', 'preparing', 'ready_to_pickup', 'completed'])],
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed'])],
        ]);
        
        // Logic to handle order approval flow
        if ($request->input('action') === 'approve') {
            $validated['order_status'] = 'preparing';
        }
        if ($request->input('action') === 'reject') {
            $validated['order_status'] = 'rejected';
        }

        $order->update($validated);

        return redirect()->route('tenant.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
