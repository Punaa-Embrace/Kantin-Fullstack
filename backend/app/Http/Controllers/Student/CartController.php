<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $menus = MenuItem::with('tenant')->take(5)->get();

        return view('student.cart.index', compact('menus'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:qris,cash',
            'cart_items' => 'required|json',
        ]);

        $cartItems = json_decode($validated['cart_items'], true);
        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $student = Auth::user();
        $paymentMethod = $validated['payment_method'];
        $createdOrders = [];
        $hasQrisOrder = false;

        // Group items by tenant_id
        $itemsByTenant = collect($cartItems)->groupBy('tenant_id');

        DB::beginTransaction();
        try {
            foreach ($itemsByTenant as $tenantId => $items) {
                $totalPrice = $items->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                });
                
                // MODIFIED: Aggregate notes for this specific tenant's order
                $studentNotes = $items->map(function ($item) {
                    if (!empty(trim($item['notes']))) {
                        return "- {$item['name']} (x{$item['quantity']}): {$item['notes']}";
                    }
                    return null;
                })->filter()->implode("\n");

                // Create the Order
                $order = Order::create([
                    'order_code' => 'JKA-' . date('ymd') . '-' . Str::upper(Str::random(4)),
                    'student_id' => $student->id,
                    'tenant_id' => $tenantId,
                    'total_price' => $totalPrice,
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'pending',
                    'order_status' => 'pending_approval',
                    'student_notes' => $studentNotes ?: null, // Save aggregated notes, or null if empty
                ]);

                // Create Order Items
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $item['id'],
                        'item_name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                $createdOrders[] = $order;
                if ($order->payment_method === 'qris') {
                    $hasQrisOrder = true;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi. Error: ' . $e->getMessage());
        }

        // Flash a session variable to signal cart clearing
        session()->flash('clear_cart', true);

        // Redirect based on the scenarios
        if ($hasQrisOrder) {
            return redirect()->route('student.payment.qris')->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
        }

        if (count($createdOrders) === 1) {
            return redirect()->route('student.orders.show', $createdOrders[0])->with('success', 'Pesanan tunai berhasil dibuat!');
        }

        return redirect()->route('student.orders.index')->with('success', 'Semua pesanan tunai berhasil dibuat!');
    }
}
