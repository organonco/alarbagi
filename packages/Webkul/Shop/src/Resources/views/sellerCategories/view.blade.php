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
            <img src="{{ $sellerCategory->image_url }}" class="w-72 h-72 rounded-full max-lg:w-40 max-lg:h-40">
        </div>

        <div class="sn-heading-1 text-center sn-color-primary pt-4">
            {{ $area->name }}
        </div>
		<div class="sn-heading-2 text-center sn-color-primary pt-1">
            {{ $sellerCategory->name  }}
        </div>
        <div class="flex gap-6 px-24 py-36 flex-wrap justify-center max-lg:px-6 max-lg:pt-14 max-lg:pb-40">
            @if ($sellers->count() > 0)
                @foreach ($sellers as $seller)
                    <a href="{{ route('shop.marketplace.show', ['slug' => $seller->slug]) }}"
                        class="w-72 py-8 max-lg:py-1 flex gap-4 flex-col max-lg:gap-2 max-lg:w-24">
                        <img src="{{ $seller->logo_url }}" class="w-72 h-72 rounded-lg max-lg:h-24">
                        <div class="sn-color-primary text-center lg:!text-3xl max-lg:!text-xl max-lg:!font-normal">
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
