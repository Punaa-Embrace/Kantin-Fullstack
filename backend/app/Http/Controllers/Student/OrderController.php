<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the authenticated student's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('tenant')
            ->latest()
            ->paginate(10);

        return view('student.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        if ($order->student_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK UNTUK MELIHAT PESANAN INI.');
        }

        $order->load(['tenant', 'items']);

        return view('student.orders.show', compact('order'));
    }
}