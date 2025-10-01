@props(['status', 'type' => 'order'])

@php
    $styles = [
        'order' => [
            'pending_approval' => 'bg-yellow-100 text-yellow-800',
            'preparing' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800',
            'ready_to_pickup' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
        ],
        'payment' => [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ]
    ];
    $class = $styles[$type][$status] ?? 'bg-gray-100 text-gray-800';
    $humanRedableTexts = [
      'pending_approval' => 'Menunggu',
      'preparing' => 'Disiapkan',
      'rejected' => 'Ditolak',
      'ready_to_pickup' => 'Siap Diambil',
      'completed' => 'Selesai',
      'pending' => 'Menunggu Pembayaran',
      'paid' => 'Sudah Dibayar',
      'failed' => 'Pembayaran Gagal',
    ]
@endphp

<span {{ $attributes->class(['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', $class]) }}>
    {{ $humanRedableTexts[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
</span>
