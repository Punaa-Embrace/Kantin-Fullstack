@extends('layouts.app')

@section('title', 'Manajemen Pesanan')
@section('header', 'Manajemen Pesanan')

@section('content')
    <div x-data="{ 
            newOrder: false, 
            orderDetails: {},
            newOrdersList: [] 
         }" 
         x-init="
            window.Echo.private('tenant.{{ auth()->user()->tenant->id }}')
                .listen('.new.order', (e) => {
                    // Show the popup notification
                    orderDetails = e;
                    newOrder = true;
                    
                    // Add the new order to the top of our list
                    newOrdersList.unshift(e);
                    
                    setTimeout(() => newOrder = false, 10000); // Hide popup after 10 seconds
                });
        ">
        {{-- New Order Notification --}}
        <div x-show="newOrder" x-transition class="fixed top-20 right-6 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50">
            <p class="font-bold">Pesanan Baru Diterima!</p>
            <p class="text-sm">
                <strong x-text="orderDetails.student_name"></strong> memesan
                <strong x-text="`Rp ${new Intl.NumberFormat('id-ID').format(orderDetails.total_price)}`"></strong>.
            </p>
            <a :href="orderDetails.order_url" @click="newOrder = false" class="mt-2 inline-block text-sm font-semibold underline">Lihat Detail</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            @include('partials._session-messages')

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Civitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- NEW: Loop for real-time new orders --}}
                        <template x-for="newOrder in newOrdersList" :key="newOrder.order_code">
                            <tr class="bg-green-50 animate-pulse-fast">
                                <td class="px-6 py-4 text-sm font-bold text-gray-700" x-text="newOrder.order_code"></td>
                                <td class="px-6 py-4 text-sm text-gray-900" x-text="newOrder.student_name"></td>
                                <td class="px-6 py-4 text-sm text-gray-600" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(newOrder.total_price)}`"></td>
                                <td class="px-6 py-4 text-sm">
                                    {{-- For simplicity, we show default status. More complex logic would require more data in the event. --}}
                                    <x-order-status-badge status="pending" type="payment" />
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <x-order-status-badge status="pending_approval" />
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a :href="newOrder.order_url" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                </td>
                            </tr>
                        </template>

                        {{-- Loop for existing orders from the server --}}
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $order->order_code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->student->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <x-order-status-badge :status="$order->payment_status" type="payment" />
                                </td>
                                <td class="px-6 py-4 text-sm"><x-order-status-badge :status="$order->order_status" /></td>
                                <td class="px-6 py-4 text-right text-sm font-medium"><a href="{{ route('tenant.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a></td>
                            </tr>
                        @empty
                            {{-- This row will only show if there are no new orders and no existing orders --}}
                            <template x-if="newOrdersList.length === 0">
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada pesanan.</td></tr>
                            </template>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        </div>
    </div>
@endsection
