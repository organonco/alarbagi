{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $sellerCategory->name }}" />
    <meta name="description" content="{{ $sellerCategory->info }}" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{ $area->name . ' - ' . $sellerCategory->name }}
    </x-slot>
    <div class="sn-background-light-green h-full">
        <div class="w-full">
            <img class="w-full" src="{{ $sellerCategory->banner_url }}" />
        </div>

        <div class="w-full flex justify-center pt-10">
            <img src="{{ $sellerCategory->image_url }}" class="w-72 h-72 rounded-full">
        </div>

        <div class="sn-heading-1 text-center sn-color-primary pt-4">
            {{ $area->name . ' - ' . $sellerCategory->name }}
        </div>

        <div class="flex gap-6 px-24 py-36 flex-wrap justify-center max-lg:px-6">
            @if ($sellers->count() > 0)
                @foreach ($sellers as $seller)
                    <a href="{{ route('shop.marketplace.show', ['slug' => $seller->slug]) }}"
                        class="items-center flex gap-8 sn-background-light-green-2 px-4 py-4 rounded-lg min-w-[450px] max-lg:min-w-full">
                        <img src="{{ $seller->logo_url }}" class="w-20 h-20 rounded-full">
                        <div
                            class="sn-color-primary text-center font-black text-2xl w-full max-lg:text-right max-lg:text-xl">
                            {{ $seller->name }}
                        </div>
                    </a>
                @endforeach
            @else
                <div
                    class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[276px] text-center">
                    <p class="sn-heading-2 sn-color-primary">
                        @lang('shop::app.categories.view.empty-category')
                    </p>
                </div>
            @endif
        </div>
    </div>

</x-shop::layouts>
