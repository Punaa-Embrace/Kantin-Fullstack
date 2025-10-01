@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', 'Panel Administrasi')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <x-tenant.stat-card title="Total Pengguna" :value="$stats['totalUsers']">
                <x-slot name="icon">
                    <x-heroicon-o-users class="w-6 h-6 text-indigo-600" />
                </x-slot>
            </x-tenant.stat-card>

            <x-tenant.stat-card title="Total Stand" :value="$stats['totalTenants']">
                <x-slot name="icon">
                    <x-heroicon-o-building-storefront class="w-6 h-6 text-sky-600" />
                </x-slot>
            </x-tenant.stat-card>

            <x-tenant.stat-card title="Total Pendapatan"
                value="Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}">
                <x-slot name="icon">
                    <x-heroicon-o-banknotes class="w-6 h-6 text-emerald-600" />
                </x-slot>
            </x-tenant.stat-card>
        </div>

        {{-- Recent Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Recent Orders --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pesanan Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="p-3 text-left">Kode</th>
                                <th class="p-3 text-left">Stand</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recentOrders as $order)
                                <tr class="text-sm">
                                    <td class="p-3 font-bold text-indigo-600">{{ $order->order_code }}</td>
                                    <td class="p-3 text-gray-700">{{ $order->tenant->name }}</td>
                                    <td class="p-3"><x-order-status-badge :status="$order->order_status" /></td>
                                    <td class="p-3 text-right font-semibold">Rp
                                        {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-gray-500">Tidak ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Users --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pengguna Baru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="p-3 text-left">Nama</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recentUsers as $user)
                                <tr class="text-sm">
                                    <td class="p-3 font-semibold text-gray-800">{{ $user->name }}</td>
                                    <td class="p-3 text-gray-600">{{ $user->email }}</td>
                                    <td class="p-3">
                                        <span @class([
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            'bg-red-100 text-red-800' => $user->role === 'admin',
                                            'bg-blue-100 text-blue-800' => $user->role === 'tenant_manager',
                                            'bg-green-100 text-green-800' => $user->role === 'student',
                                        ])>{{ $user->role_string }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-10 text-center text-gray-500">Tidak ada pengguna baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
