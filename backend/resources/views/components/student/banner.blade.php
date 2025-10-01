@php
// Static data for demonstration. In a real application, you would pass this from the controller.
$banners = [
    [
        'title_line_1' => 'Mager Ke Kantin?',
        'title_line_2' => 'Pesan Di JakaAja',
        'image' => asset('images/dashboard/woman.png'),
        'bg_color' => 'bg-yellow-500',
    ],
    // [
    //     'title_line_1' => 'Promo Spesial Hari Ini!',
    //     'title_line_2' => 'Diskon 20% Minuman',
    //     'image' => 'https://placehold.co/400x225/4ade80/ffffff?text=Promo!',
    //     'bg_color' => 'bg-green-500',
    // ],
    // [
    //     'title_line_1' => 'Baru di Kantin RTF!',
    //     'title_line_2' => 'Cobain Ayam Gepreknya',
    //     'image' => 'https://placehold.co/400x225/fb923c/ffffff?text=Menu+Baru',
    //     'bg_color' => 'bg-orange-500',
    // ],
];
@endphp

<section>
    {{-- Horizontally Scrolling Container --}}
    <div class="flex gap-4 -mx-6 px-6 overflow-x-auto pb-4 no-scrollbar snap-x snap-mandatory">

        @foreach ($banners as $banner)
            {{-- This outer div controls the width and snapping of each banner card --}}
            <div class="flex-shrink-0 w-full sm:w-[90%] md:w-4/5 lg:w-3/4 max-w-4xl snap-center">
                
                {{-- This is the actual banner card, which now contains all its own styling and decorative elements --}}
                <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-lg max-h-64 p-6 sm:p-8 text-white {{ $banner['bg_color'] }}">
                    
                    {{-- Decorative Circles (now inside each banner) --}}
                    <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/20 rounded-full"></div>
                    <div class="absolute -top-10 right-40 w-72 h-72 bg-white/20 rounded-full hidden sm:block"></div>
                    <div class="absolute -bottom-24 right-0 w-72 h-72 bg-white/20 rounded-full"></div>
                    
                    {{-- Content Wrapper --}}
                    <div class="relative z-10 flex items-end h-full">
                        {{-- Text Content (Takes up 2/3 of the space) --}}
                        <div class="flex-[2]">
                            <h2 class="text-2xl md:text-4xl font-bold leading-tight">
                                {!! $banner['title_line_1'] !!}<br>{!! $banner['title_line_2'] !!}
                            </h2>
                        </div>
                        
                        {{-- Image (Takes up 1/3 of the space) --}}
                        <div class="flex-1 hidden sm:block">
                            <img src="{{ $banner['image'] }}" alt="Banner Image" class="w-full h-full object-contain object-right-bottom -mb-8">
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</section>
