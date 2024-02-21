@php
    $channel = core()->getCurrentChannel();
@endphp

@push('styles')
    <style>
        .cart-floating-button {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #0C9;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-floating-button .number {
            top: 5px;
            left: 12px
        }
    </style>
@endpush

{{-- SEO Meta Content --}}
@push ('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? '' }}"/>

    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? '' }}"/>

    <meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"/>
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
        </x-slot>

        {{-- Loop over the theme customization --}}
        @foreach ($customizations as $customization)
            @php ($data = $customization->options)

            {{-- Static content --}}
            @switch ($customization->type)
                {{-- Image Carousel --}}
                @case ($customization::IMAGE_CAROUSEL)
                    <x-shop::carousel :options="$data"></x-shop::carousel>

                    @break

                @case ($customization::STATIC_CONTENT)
                    {{-- push style --}}
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush

                    {{-- render html --}}
                    {!! $data['html'] !!}

                    @break

                @case ($customization::CATEGORY_CAROUSEL)
                    {{-- Categories carousel --}}
                    <x-shop::categories.carousel
                            :title="$data['title'] ?? ''"
                            :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                            :navigation-link="route('shop.home.index')"
                    >
                    </x-shop::categories.carousel>

                    @break

                @case ($customization::PRODUCT_CAROUSEL)
                    {{-- Product Carousel --}}
                    <x-shop::products.carousel
                            {{-- title="Men's Collections" --}}
                            :title="$data['title'] ?? ''"
                            :src="route('shop.api.products.index', $data['filters'] ?? [])"
                            :navigation-link="route('shop.products.index', array_merge($data['filters'], ['title' => $data['title']]) ?? [])"
                    >
                    </x-shop::products.carousel>
                    @break
                @case($customization::SMALL_BANNER)
                    <div class="banner container mt-20">
                        @if($customization->options['images'][0]['link'])
                            <a href="{{$customization->options['images'][0]['link']}}" target="_blank">
                                <img src="{{asset($customization->options['images'][0]['image'])}}"/>
                            </a>
                        @else
                            <img src="{{asset($customization->options['images'][0]['image'])}}"/>
                        @endif
                    </div>
                    @break

                @case($customization::IMAGE_WITH_TEXT)
                    @if($customization->options)
                        <div class="container section-gap home-page-container">
                            <div class="inline-col-wrapper">
                                <div class="inline-col-image-wrapper">
                                    <img src="{{asset($customization->options['banner'])}}" width="632" height="510"
                                         alt="">
                                </div>
                                <div class="inline-col-content-wrapper">
                                    <h2 class="inline-col-title sn-color-light-main"> {{$customization['options']['title']}} </h2>
                                    <p class="inline-col-description sn-color-secondary">{{$customization['options']['text']}}</p>
                                    <a href="{{$customization->options['link']}}" target="_blank">
                                        <button class="sn-button-primary" style="color: white">View All</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @break
            @endswitch
        @endforeach

        @foreach($categories as $category)
            @php($filters = ['sort' => 'created_at-desc', 'limit' => '8', 'category_id' => $category['id']])
            <x-shop::products.carousel
                    title="{{$category->name}}"
                    :src="route('shop.api.products.index', $filters ?? [])"
                    :navigation-link="route('shop.product_or_category.index', $category['slug'])"
            >
            </x-shop::products.carousel>
    @endforeach
</x-shop::layouts>
