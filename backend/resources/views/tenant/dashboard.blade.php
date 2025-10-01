@extends('layouts.app')

@section('title', 'Dashboard Pengelola')
@section('header', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-tenant.stat-card 
            title="Total Pesanan" 
            :value="$currentTotalOrders" 
            :change="$totalOrdersChange">
            <x-slot name="icon">
                <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-green-600" />
            </x-slot>
        </x-tenant.stat-card>

        <x-tenant.stat-card 
            title="Total Batal Pesanan" 
            :value="$currentCancelledOrders" 
            :change="$cancelledOrdersChange">
            <x-slot name="icon">
                <x-heroicon-o-x-circle class="w-6 h-6 text-red-600" />
            </x-slot>
        </x-tenant.stat-card>
        
        <x-tenant.stat-card 
            title="Pendapatan (30 Hari)" 
            value="Rp {{ number_format($currentRevenue, 0, ',', '.') }}" 
            :change="$revenueChange">
            <x-slot name="icon">
                <x-heroicon-o-credit-card class="w-6 h-6 text-blue-600" />
            </x-slot>
        </x-tenant.stat-card>
    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
            <a href="{{ route('tenant.orders.index') }}" class="text-sm font-semibold text-green-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Civitas</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-3 text-sm font-bold text-indigo-600 hover:underline">
                                <a href="{{ route('tenant.orders.show', $order) }}">{{ $order->order_code }}</a>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order->student->name }}</td>
                            <td class="px-4 py-3 text-sm">
                                <x-order-status-badge :status="$order->order_status" />
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">Tidak ada pesanan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
