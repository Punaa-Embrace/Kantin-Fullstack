<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display the QRIS payment page with order details grouped by tenant.
     */
    public function showQris()
    {
        $user = Auth::user();

        // Fetch all pending QRIS orders for the authenticated student.
        // Eager-load tenant and items relationships for efficiency.
        $pendingQrisOrders = Order::where('student_id', $user->id)
            ->where('payment_method', 'qris')
            ->where('payment_status', 'pending')
            ->with(['tenant', 'items'])
            ->get();

        return view('student.payment.qris', ['ordersByTenant' => $pendingQrisOrders]);
    }

    /**
     * Store the proof of payment for a specific order.
     * This is a placeholder for the actual logic.
     */
    public function storeProof(Request $request, $order_code)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // In a real implementation, you would find the order and attach the media:
        $order = Order::where('order_code', $order_code)->where('student_id', auth()->id())->firstOrFail();
        $order->addMediaFromRequest('payment_proof')->toMediaCollection('payment_proof');
        
        // For now, let's just mark it as paid. A better status might be 'waiting_confirmation'.
        $order->update(['payment_status' => 'paid']); 

        // For now, we just redirect back with a success message.
        return back()->with('success', "Bukti bayar untuk order #{$order_code} berhasil diunggah! Pesanan Anda akan segera diproses.");
    }
}
