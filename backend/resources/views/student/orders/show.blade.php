@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_code)
@section('header', 'Detail Pesanan')

@section('content')
    <div class="container mx-auto" x-data="orderStatusData({{ json_encode($order) }})">
        <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">

            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->order_code }}</h2>
                    <p class="text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-500">Stand: <span class="font-semibold">{{ $order->tenant->name }}</span></p>
                </div>
                <div class="flex items-center gap-4">
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-semibold">Status Pesanan</span>
                        <p :class="orderStatusClasses"
                            class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full" x-text="orderStatusText">
                        </p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-semibold">Status Bayar</span>
                        <p :class="paymentStatusClasses"
                            class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full"
                            x-text="paymentStatusText"></p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <!-- Status: Pending Approval -->
                <template x-if="currentOrderStatus === 'pending_approval'">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-center rounded-r-lg">
                        <div class="flex justify-center items-center">
                            <div class="py-1"><x-heroicon-o-clock class="w-10 h-10 text-yellow-500" /></div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-yellow-800">Menunggu Konfirmasi</h3>
                                <p class="text-sm text-yellow-700">Pesanan Anda sedang menunggu persetujuan dari pihak
                                    kantin.</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Status: Preparing -->
                <template x-if="currentOrderStatus === 'preparing'">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-center rounded-r-lg">
                        <div class="flex justify-center items-center">
                            <div class="py-1"><x-heroicon-o-users class="w-10 h-10 text-blue-500" /></div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-blue-800">Pesanan Disiapkan</h3>
                                <p class="text-sm text-blue-700">Mantap! Pesanan Anda sedang dibuat, ditunggu ya.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Status: Ready to Pickup -->
                <template x-if="currentOrderStatus === 'ready_to_pickup'">
                    <div class="bg-green-50 border-l-4 border-green-400 p-6 text-center rounded-r-lg">
                        <div class="flex flex-col items-center">
                            <x-heroicon-o-archive-box class="w-16 h-16 text-green-500" />
                            <h3 class="text-2xl font-bold text-green-800 mt-4">Pesanan Siap Diambil!</h3>
                            <p class="text-md text-green-700">Silakan tunjukkan kode pesanan di bawah ini saat mengambil pesanan.</p>
                            <div class="mt-4 bg-gray-100 px-6 py-2 rounded-lg border-2 border-dashed border-gray-300">
                                <p class="text-3xl font-extrabold text-gray-800 tracking-widest">{{ $order->order_code }}
                                </p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Status: Rejected -->
                <template x-if="currentOrderStatus === 'rejected'">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 text-center rounded-r-lg">
                        <div class="flex justify-center items-center">
                            <div class="py-1"><x-heroicon-o-x-circle class="w-10 h-10 text-red-500" /></div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-red-800">Pesanan Ditolak</h3>
                                <p class="text-sm text-red-700">Mohon maaf, pesanan Anda tidak dapat diproses. Silakan
                                    hubungi kantin atau coba lagi.</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Status: Completed -->
                <template x-if="currentOrderStatus === 'completed'">
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 text-center rounded-r-lg">
                        <div class="flex justify-center items-center">
                            <div class="py-1"><x-heroicon-o-check-circle class="w-10 h-10 text-gray-500" /></div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-800">Pesanan Selesai</h3>
                                <p class="text-sm text-gray-700">Terima kasih telah memesan di JakaAja! Sampai jumpa di
                                    pesanan berikutnya.</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>


            <h3 class="text-lg font-bold text-gray-700 mb-4">Rincian Item</h3>
            <div class="space-y-4 mb-6">
                @foreach ($order->items as $item)
                    <div class="flex justify-between items-center text-gray-700">
                        <div>
                            <p class="font-semibold">{{ $item->item_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                                {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ======================================================= --}}
            {{--                   NEW NOTES SECTION                     --}}
            {{-- ======================================================= --}}
            @if ($order->student_notes)
                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Catatan Pesanan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $order->student_notes }}</p>
                    </div>
                </div>
            @endif

            <div class="mt-6 pt-6 border-t border-dashed">
                <div class="flex justify-between items-center text-lg font-bold text-gray-800">
                    <span>Total Pesanan</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($order->payment_method === 'qris' && $order->payment_status === 'pending')
                <div class="mt-8 text-center bg-yellow-50 border border-yellow-300 p-4 rounded-lg">
                    <p class="text-yellow-800">Anda belum menyelesaikan pembayaran untuk pesanan ini.</p>
                    <a href="{{ route('student.payment.qris') }}"
                        class="mt-2 inline-block font-bold text-blue-600 hover:underline">Selesaikan Pembayaran</a>
                </div>
            @endif

            @if ($order->hasMedia('payment_proof'))
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Bukti Pembayaran</h3>
                    <img src="{{ $order->getFirstMediaUrl('payment_proof') }}" alt="Bukti Pembayaran"
                        class="max-w-xs rounded-lg shadow-md">
                </div>
            @endif

        </div>
    </div>

    <script>
        function orderStatusData(order) {
            return {
                currentOrderStatus: order.order_status,
                currentPaymentStatus: order.payment_status,

                init() {
                    // Listen for real-time updates
                    window.Echo.private(`orders.${order.id}`)
                        .listen('.order.status.updated', (e) => {
                            console.log(e);
                            // Check if the update is for this specific order
                            if (e.order_id === order.id) {
                                this.currentOrderStatus = e.order_status;
                                this.currentPaymentStatus = e.payment_status;
                            }
                        });
                },

                get orderStatusText() {
                    return this.currentOrderStatus.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                },

                get paymentStatusText() {
                    return this.currentPaymentStatus.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
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
