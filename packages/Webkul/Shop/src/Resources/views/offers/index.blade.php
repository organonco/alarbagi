{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="العروض الخاصة" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        العروض الخاصة
    </x-slot>
    <div class="sn-background-light-green py-32 px-16 max-lg:px-4 max-lg:py-8">
        <div class="flex flex-row max-lg:flex-col gap-8 items-center justify-center flex-wrap">
            @foreach ($offers as $offer)
                <x-shop::offer :title="$offer->title" :post="$offer->post" :image="$offer->image_url" :seller="$offer->seller"></x-shop::offer>
            @endforeach
        </div>
    </div>
</x-shop::layouts>
