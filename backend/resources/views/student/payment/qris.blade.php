@extends('layouts.app')

@section('title', 'Pembayaran QRIS')
@section('header', 'Pembayaran QRIS')

@section('content')
<div class="container mx-auto">
    <div class="max-w-4xl mx-auto space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-zinc-800">Selesaikan Pembayaran Anda</h1>
            <p class="text-gray-600 mt-1">Satu langkah lagi! Scan QRIS, lalu unggah bukti pembayaran untuk setiap stand.</p>
        </div>

        @include('partials._session-messages')

        {{-- Horizontal Scrolling Container --}}
        <div class="flex space-x-6 overflow-x-auto pb-4 -mx-6 px-6 snap-x snap-mandatory">
            @forelse($ordersByTenant as $order)
                <div class="flex-shrink-0 w-full max-w-sm snap-center">
                    <form action="{{ route('student.payment.store_proof', $order->order_code) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col h-full">
                        @csrf
                        <!-- Header -->
                        <div class="bg-green-600 p-4">
                            <h2 class="text-xl font-bold text-white text-center">Pembayaran untuk {{ $order->tenant->name }}</h2>
                        </div>
        
                        <!-- Content -->
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex-grow flex flex-col items-center">
                                <!-- QR Code Section -->
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-extrabold mb-1">Scan QR Code</h3>
                                    <p class="font-semibold text-sm">{{ $order->tenant->name }}</p>
                                    <p class="text-xs text-gray-500 mb-4">{{ $order->tenant->slug }}</p>
                                    
                                    <div class="flex justify-center mb-4">
                                        <img src="{{ $order->tenant->getFirstMediaUrl('qris') ?: 'https://placehold.co/200x200/e2e8f0/64748b?text=QRIS+Belum+Tersedia' }}" alt="QR Code for {{ $order->tenant->name }}" class="w-48 border-4 border-gray-200 rounded-lg p-1"/>
                                    </div>
                                    
                                    <p class="text-xs text-gray-600">Scan QRIS menggunakan aplikasi E-Wallet Anda (GoPay, OVO, DANA, dll).</p>
                                </div>
        
                                <!-- Price Details Section -->
                                <div class="w-full">
                                    <div class="bg-gray-50 rounded-lg p-4 text-sm space-y-3">
                                        <div class="flex justify-between font-bold text-lg border-b pb-2">
                                          <span>Total Harga:</span>
                                          <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                        </div>
                                        @foreach($order->items as $item)
                                        <div class="flex justify-between items-center text-gray-700">
                                          <span class="font-medium">{{ $item->item_name }}</span>
                                          <div class="flex-grow text-right pr-4">
                                              <span class="text-xs text-gray-500">{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</span>
                                          </div>
                                          <span class="font-semibold w-20 text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Upload & Actions -->
                            <div class="mt-6 border-t pt-6">
                                <div x-data="{
                                    previewUrl: '',
                                    handleFileChange(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            this.previewUrl = URL.createObjectURL(file);
                                        } else {
                                            this.previewUrl = '';
                                        }
                                    }
                                }">
                                    <label for="payment_proof_{{ $loop->index }}" class="block text-sm font-medium text-gray-700 mb-2">Unggah Bukti Pembayaran</label>
                                    <div class="flex items-center space-x-4">
                                        <label for="payment_proof_{{ $loop->index }}" class="flex-1 cursor-pointer bg-white border border-gray-300 rounded-md py-2 px-3 shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <span x-text="previewUrl ? 'Ganti File' : 'Pilih File'"></span>
                                            <input id="payment_proof_{{ $loop->index }}" name="payment_proof" type="file" class="sr-only" @change="handleFileChange" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                                        </label>
                                        <div class="shrink-0" x-show="previewUrl">
                                            <img class="h-10 w-10 object-cover rounded" :src="previewUrl" alt="Preview Bukti Bayar">
                                        </div>
                                    </div>
                                     @error('payment_proof')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
                                        Unggah & Konfirmasi Pembayaran
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @empty
                <div class="col-span-full w-full">
                    <div class="bg-white p-12 rounded-lg shadow-sm text-center">
                        <x-heroicon-o-check-circle class="mx-auto h-12 w-12 text-green-400" />
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak Ada Pembayaran Tertunda</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Semua pembayaran QRIS Anda sudah lunas.
                        </p>
                        <div class="mt-6">
                          <a href="{{ route('student.orders.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Lihat Riwayat Pesanan
                          </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if(!$ordersByTenant->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">
            <h3 class="text-lg font-bold text-center mb-4">Sudah Mengunggah Semua Bukti Pembayaran?</h3>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors">
                    Selesai, Kembali ke Dashboard
                </a>
                <a href="{{ route('student.cart.index') }}" class="w-full sm:w-auto text-center border border-gray-300 text-gray-700 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                    Kembali ke Keranjang
                </a>
            </div>
             <p class="text-xs text-gray-500 text-center mt-4">Pesanan Anda akan diproses setelah pembayaran dikonfirmasi oleh pengelola stand.</p>
        </div>
        @endif

    </div>
</div>
@endsection
