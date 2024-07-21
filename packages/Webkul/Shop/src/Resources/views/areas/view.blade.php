{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $area->name }}" />
    <meta name="description" content="{{ $area->info }}" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{ $area->name }}
    </x-slot>
    <div class="sn-background-light-grey">
        <div class="w-full">
            <img class="w-full" src="{{ $area->banner_url }}" />
        </div>

        <div class="w-full flex justify-center pt-10">
            <img src="{{ $area->image_url }}" class="w-72 h-72 rounded-full">
        </div>

        <div class="sn-heading-1 text-center sn-color-primary pt-4">
            {{ $area->name }}
        </div>

        <div class="flex gap-6 px-24 py-36 flex-wrap justify-center max-lg:px-6">
            @foreach ($categories as $category)
                <a href="{{ route('seller-category.view', ['areaId' => $area->id, 'sellerCategoryId' => $category->id]) }}"
                    class="items-center flex gap-8 sn-background-light-green px-4 py-4 rounded-lg min-w-[450px] max-lg:min-w-full">
                    <img src="{{ $category->image_url }}" class="w-20 h-20 rounded-full">
                    <div
                        class="sn-color-primary text-center font-black text-2xl w-full max-lg:text-right max-lg:text-xl">
                        {{ $category->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-shop::layouts>
