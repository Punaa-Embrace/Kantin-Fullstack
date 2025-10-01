@extends('layouts.app')

@section('title', 'Keranjang Saya')
@section('header', 'Keranjang Saya')

@section('content')
    <div class="container mx-auto" x-data="cartPage()">

        @include('partials._session-messages')

        {{-- Main Cart View --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7">
                <h2 class="text-2xl font-bold text-zinc-800 mb-6">Daftar Pesanan</h2>
                <div class="space-y-4">
                    <template x-if="$store.cart.items.length === 0">
                        <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                            <p class="text-gray-500">Keranjang Anda masih kosong.</p>
                            <a href="{{ route('student.menus.index') }}"
                                class="mt-4 inline-block text-green-600 font-semibold hover:underline">Mulai Belanja</a>
                        </div>
                    </template>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="item in $store.cart.items" :key="item.id">
                           <x-student.cart-item-card />
                        </template>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="sticky top-6">
                    <form x-ref="checkoutForm" action="{{ route('student.cart.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" x-model="paymentMethod">
                        <input type="hidden" name="cart_items" :value="JSON.stringify($store.cart.items)">

                        <div class="bg-lemon p-6 rounded-2xl shadow">
                            <h2 class="text-2xl font-bold mb-6">Detail Pembayaran</h2>
                            <div class="space-y-3 border-green-500 pb-4 mb-4">
                                <div class="flex justify-between items-center text-white">
                                    <span>Jumlah Item</span>
                                    <span class="font-semibold" x-text="$store.cart.totalItems"></span>
                                </div>
                                <div class="flex justify-between items-center text-white">
                                    <span>Subtotal Pesanan</span>
                                    <span class="font-semibold" x-text="`Rp ${formatCurrency($store.cart.subtotal)}`"></span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center font-bold text-xl mb-6">
                                <span>Total</span>
                                <span x-text="`Rp ${formatCurrency($store.cart.subtotal)}`"></span>
                            </div>
                            <h3 class="font-bold text-zinc-800 mb-3">Pilih Jenis Pembayaran</h3>
                            <div class="grid grid-cols-3 gap-4">
                                <button type="button" @click="paymentMethod = 'qris'"
                                    :class="{ 'ring-2 ring-green-600': paymentMethod === 'qris' }"
                                    class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-center transition-all">
                                    <img src="{{ asset('images/payment/qris.png') }}" alt="QRIS" class="h-8 mx-auto mb-2">
                                    <span class="font-semibold text-sm">QRIS</span>
                                </button>
                                <div class="flex items-center justify-center h-full">
                                    <p class="text-center text-sm font-medium">Atau</p>
                                </div>
                                <button type="button" @click="paymentMethod = 'cash'"
                                    :class="{ 'ring-2 ring-green-600': paymentMethod === 'cash' }"
                                    class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-center transition-all">
                                    <img src="{{ asset('images/payment/cash.png') }}" alt="Cash" class="h-8 mx-auto mb-2">
                                    <span class="font-semibold text-sm">Tunai</span>
                                </button>
                            </div>
                            {{-- MODIFIED: Removed @click event handler --}}
                            <button type="submit" :disabled="$store.cart.items.length === 0"
                                class="w-full bg-white font-bold py-3.5 mt-6 rounded-xl text-lg hover:bg-gray-300 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed disabled:text-gray-500">
                                Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cartPage() {
            return {
                paymentMethod: 'qris',
                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID').format(amount);
                }
            }
        }
    </script>
@endsection
