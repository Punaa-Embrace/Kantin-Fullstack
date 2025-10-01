@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_code)
@section('header', 'Detail Pesanan')

@section('content')
<div class="container mx-auto" x-data="orderStatusData({{ json_encode($order) }})">
    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">
        @include('partials._session-messages')

        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->order_code }}</h2>
                <p class="text-sm text-gray-500">Dari: <span class="font-semibold">{{ $order->student->name }}</span></p>
                <p class="text-sm text-gray-500">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="w-full sm:w-auto">
                <form action="{{ route('tenant.orders.updateStatus', $order) }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    @method('PATCH')

                    @if($order->order_status === 'pending_approval')
                        <div class="flex gap-3">
                            <button type="submit" name="action" value="reject" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Tolak</button>
                            <button type="submit" name="action" value="approve" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Terima</button>
                        </div>
                    @elseif($order->order_status === 'preparing')
                         <button type="submit" name="order_status" value="ready_to_pickup" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Tandai Siap Diambil</button>
                    @elseif($order->order_status === 'ready_to_pickup')
                         <button type="submit" name="order_status" value="completed" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Selesaikan Pesanan</button>
                    @endif
                </form>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-4">Rincian Item</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center text-gray-700">
                        <div>
                            <p class="font-semibold">{{ $item->item_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                @if($order->student_notes)
                <div class="mt-6 pt-4 border-t">
                    <h4 class="font-bold text-gray-600">Catatan dari Civitas:</h4>
                    <p class="text-sm text-gray-800 mt-1 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $order->student_notes }}</p>
                </div>
                @endif
                <div class="mt-6 pt-6 border-t font-bold text-lg flex justify-between">
                    <span>Total Pesanan</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-4">Detail Status & Pembayaran</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Status Pesanan:</span>
                        {{-- MODIFIED: Added x-text and :class bindings --}}
                        <p x-text="orderStatusText" :class="orderStatusClasses" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"></p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Metode Bayar:</span>
                        <span class="font-bold text-gray-800">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Status Bayar:</span>
                        {{-- MODIFIED: Added x-text and :class bindings --}}
                        <p x-text="paymentStatusText" :class="paymentStatusClasses" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"></p>
                    </div>

                    @if($order->payment_method === 'qris' && $order->hasMedia('payment_proof'))
                        <div class="pt-4 border-t">
                            <p class="text-sm font-medium text-gray-600 mb-2">Bukti Pembayaran:</p>
                            <a href="{{ $order->getFirstMediaUrl('payment_proof') }}" target="_blank">
                                <img src="{{ $order->getFirstMediaUrl('payment_proof') }}" alt="Bukti Pembayaran" class="max-w-full rounded-lg shadow-sm hover:ring-2 ring-blue-500 transition">
                            </a>
                        </div>
                    @endif

                    @if($order->payment_method === 'cash' && $order->payment_status === 'pending')
                    <div class="pt-4 border-t">
                         <form action="{{ route('tenant.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="payment_status" value="paid" class="w-full border border-green-500 text-green-600 hover:bg-green-50 font-bold py-2 px-4 rounded-lg">Tandai Sudah Dibayar (Tunai)</button>
                         </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('tenant.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</div>

<script>
    function orderStatusData(order) {
        return {
            currentOrderStatus: order.order_status,
            currentPaymentStatus: order.payment_status,

            init() {
                // Listen for real-time updates on the order-specific channel
                window.Echo.private(`orders.${order.id}`)
                    .listen('.order.status.updated', (e) => {
                        console.log('Tenant received order update:', e);
                        if (e.order_id === order.id) {
                            this.currentOrderStatus = e.order_status;
                            this.currentPaymentStatus = e.payment_status;
                        }
                    });
            },

            get orderStatusText() {
                return (this.currentOrderStatus || '').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            },

            get paymentStatusText() {
                return (this.currentPaymentStatus || '').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            },

            get orderStatusClasses() {
                const statuses = {
                    pending_approval: 'bg-yellow-100 text-yellow-800',
                    preparing: 'bg-blue-100 text-blue-800',
                    rejected: 'bg-red-100 text-red-800',
                    ready_to_pickup: 'bg-green-100 text-green-800',
                    completed: 'bg-gray-100 text-gray-800',
                };
                return statuses[this.currentOrderStatus] || 'bg-gray-100 text-gray-800';
            },

            get paymentStatusClasses() {
                const statuses = {
                    pending: 'bg-yellow-100 text-yellow-800',
                    paid: 'bg-green-100 text-green-800',
                    failed: 'bg-red-100 text-red-800',
                };
                return statuses[this.currentPaymentStatus] || 'bg-gray-100 text-gray-800';
            }
        }
    }
</script>
@endsection
