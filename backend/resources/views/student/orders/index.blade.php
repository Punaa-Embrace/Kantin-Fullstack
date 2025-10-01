@extends('layouts.app')

@section('title', 'Pesanan Saya')
@section('header', 'Riwayat Pesanan Saya')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Semua Pesanan Anda</h2>
            </div>

            @include('partials._session-messages')

             <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                                Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Stand</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Bayar</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">
                                    {{ $order->order_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $order->tenant->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{-- MODIFIED: Use the component --}}
                                    <x-order-status-badge :status="$order->order_status" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{-- MODIFIED: Use the component with type="payment" --}}
                                    <x-order-status-badge :status="$order->payment_status" type="payment" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('student.orders.show', $order) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Anda belum memiliki riwayat
                                    pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
