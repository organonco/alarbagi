{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $area->name }}" />
    <meta name="description" content="{{ $area->info }}" />
@endPush

<x-shop::layouts :has-footer="true">
    <x-slot:title>
        {{ $area->name }}
    </x-slot>
    <div class="sn-background-light-green">
        
        <div class="w-full">
            <img class="w-full" src="{{ $area->banner_url }}" />
        </div>

        <div class="w-full flex justify-center pt-10">
            <img src="{{ $area->image_url }}" class="w-72 h-72 rounded-full max-lg:w-40 max-lg:h-40">
        </div>

        <div class="sn-heading-1 text-center sn-color-primary pt-4">
            {{ $area->name }}
        </div>

        <div class="flex gap-6 max-lg:gap-3 px-20 py-10 max-lg:py-14 flex-wrap justify-center max-lg:px-6">
            @foreach ($categories as $index => $category)
                @if ($category->isParent())
                    <div
                        class=" items-start flex  flex-col gap-8 sn-background-light-green-2 px-4 py-4 max-lg:px-2 max-lg:py-2 rounded-lg min-w-[450px] max-lg:min-w-full max-h-fit h-fit">
                        <div class="items-center flex  gap-8 cursor-pointer w-full"
                            onclick="handleToggle({{ $index }})">
                            <img src="{{ $category->image_url }}" class="w-20 h-20 rounded-full">
                            <div
                                class="sn-color-primary text-right font-black text-2xl w-full max-lg:text-right max-lg:text-xl">
                                {{ $category->name }}
                            </div>
                        </div>
                        <div class="hidden w-full " id="hidden_part_{{ $index }}">
                            <div class="flex flex-col gap-4 w-full">
                                @foreach ($category->getChildren() as $child)
                                    <a href="{{ route('seller-category.view', ['areaId' => $area->id, 'sellerCategoryId' => $child->id]) }}"
                                        class="sn-body-1 text-right sn-color-primary">
                                        <span class="dot ml-3"></span> {{ $child->name }}
                                    </a>
                                    <hr />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('seller-category.view', ['areaId' => $area->id, 'sellerCategoryId' => $category->id]) }}"
                        class=" items-start flex  flex-col gap-8 sn-background-light-green-2 px-4 py-4 max-lg:px-2 max-lg:py-2 rounded-lg min-w-[450px] max-lg:min-w-full max-h-fit h-fit">
                        <div class="items-center flex  gap-8 cursor-pointer w-full">
                            <img src="{{ $category->image_url }}" class="w-20 h-20 rounded-full">
                            <div
                                class="sn-color-primary text-right font-black text-2xl w-full max-lg:text-right max-lg:text-xl">
                                {{ $category->name }}
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
    @push('scripts')
        <script>
            function handleToggle(index) {
                let subCategoriesElement = document.getElementById("hidden_part_" + index)
                if (subCategoriesElement.classList.contains("hidden"))
                    subCategoriesElement.classList.remove('hidden')
                else
                    subCategoriesElement.classList.add('hidden')
            }
        </script>
    @endpush
</x-shop::layouts>
