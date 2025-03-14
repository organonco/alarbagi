@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = round($reviewHelper->getAverageRating($product));

    $percentageRatings = $reviewHelper->getPercentageRating($product);

    $customAttributeValues = $productViewHelper->getAdditionalData($product);
@endphp

{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description"
        content="{{ trim($product->meta_description) != '' ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}" />

    <meta name="keywords" content="{{ $product->meta_keywords }}" />

    @if (core()->getConfigData('catalog.rich_snippets.products.enable'))
        <script type="application/ld+json">
            {{ app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) }}
        </script>
    @endif

    <?php $productBaseImage = product_image()->getProductBaseImage($product); ?>

    <meta name="twitter:card" content="summary_large_image" />

    <meta name="twitter:title" content="{{ $product->name }}" />

    <meta name="twitter:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta name="twitter:image:alt" content="" />

    <meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:type" content="og:product" />

    <meta property="og:title" content="{{ $product->name }}" />

    <meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta property="og:url" content="{{ route('shop.product_or_category.index', $product->url_key) }}" />
@endPush

{{-- Page Layout --}}
<x-shop::layouts :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        {{ trim($product->meta_title) != '' ? $product->meta_title : $product->name }}
    </x-slot>

    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

    {{-- Breadcrumbs --}}
    <div class="flex justify-center max-lg:hidden">
        <x-shop::breadcrumbs name="product" :entity="$product"></x-shop::breadcrumbs>
    </div>

    {{-- Product Information Vue Component --}}
    <v-product :product-id="{{ $product->id }}">
        <x-shop::shimmer.products.view />
    </v-product>

    {{-- Featured Products --}}
    <x-shop::products.carousel :title="trans('shop::app.products.view.related-product-title')" :src="route('shop.api.products.related.index', ['id' => $product->id])">
    </x-shop::products.carousel>

    {{-- Upsell Products --}}
    <x-shop::products.carousel :title="trans('shop::app.products.view.up-sell-title')" :src="route('shop.api.products.up-sell.index', ['id' => $product->id])">
    </x-shop::products.carousel>

    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

    @pushOnce('scripts')
        <script type="text/x-template" id="v-product-template">
            <x-shop::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                <form
                    ref="formData"
                    @submit="handleSubmit($event, addToCart)"
                >
                    <input
                        type="hidden"
                        name="product_id"
                        value="{{ $product->id }}"
                    >

                    <input
                        type="hidden"
                        name="is_buy_now"
                        v-model="is_buy_now"
                    >

                    <input
                        type="hidden"
                        name="quantity"
                        :value="qty"
                    >
                    <input type="hidden" name="variant" :value="selectedVariantId"/>

                    <div class="container px-[60px] max-1180:px-[0px]">
                        <div class="flex gap-[40px] mt-[48px] max-1180:flex-wrap max-lg:mt-0 max-sm:gap-y-[25px]">
                            <!-- Gallery Blade Inclusion -->
                            @include('shop::products.view.gallery')

                            <!-- Details -->
                            <div class="max-w-[590px] relative max-1180:w-full max-1180:max-w-full max-1180:px-[20px] pb-16">
                                {!! view_render_event('bagisto.shop.products.name.before', ['product' => $product]) !!}

                                <div class="flex gap-[15px] justify-between">
                                    <h1 class=" sn-color-primary max-lg:!text-2xl font-bold text-4xl">
                                        {{ $product->name }}
                                    </h1>

                                    @if (core()->getConfigData('general.content.shop.wishlist_option'))
                                        <div
                                            class="flex items-center justify-center min-w-[46px] min-h-[46px] max-h-[46px] bg-white border border-black rounded-full text-[24px] transition-all hover:opacity-[0.8] cursor-pointer sn-border-main sn-color-light-main"
                                            :class="isWishlist ? 'icon-heart-fill' : 'icon-heart'"
                                            @click="addToWishlist"
                                        >
                                        </div>
                                    @endif
                                </div>

                                <a class="text-[18px] font-light max-sm:text-[12px] sn-color-dark  sn-body" href="{{route('shop.marketplace.show', $product->seller_slug)}}">
                                    {{__('marketplace::app.catalog.products.view.sold_by')}} <span class="font-bold sn-color-secondary"> {{$product->seller_name}} </span>
                                </a>
                                <div class="sn-color-dark  sn-body">
                                    @php
                                        $preperation_time = $product->preperation_time;
                                    @endphp

                                    @lang("marketplace::app.catalog.products.view.preperation_time"):
									@if($preperation_time == 0)
										{{trans_choice('marketplace::app.catalog.products.view.preperation_time_none', (int) (60*$preperation_time))}}
                                    @elseif($preperation_time < 1 && $preperation_time > 0)
                                        {{trans_choice('marketplace::app.catalog.products.view.preperation_time_minutes', (int) (60*$preperation_time))}}
                                    @elseif($preperation_time < 24)
                                        {{trans_choice('marketplace::app.catalog.products.view.preperation_time_hours', ($preperation_time))}}
                                    @elseif($preperation_time >= 24)
                                    {{trans_choice('marketplace::app.catalog.products.view.preperation_time_days', (int)($preperation_time / 24))}}
                                    @endif
                                </div>
                                <div class="sn-color-dark  sn-body">
                                    @lang('marketplace::app.catalog.products.view.deliverable.' . ($product->is_deliverable ? 'true' : 'false'))
                                </div>

                                
                                @if($product->stock_quantity > 0)
                                <a class="text-[18px] font-light max-sm:text-[12px] sn-color-secondary" href="{{route('shop.marketplace.show', $product->seller_slug)}}">
                                    {{__('marketplace::app.catalog.products.view.available', ['qty' => $product->stock_quantity])}}
                                </a>
                                @elseif($product->stock_quantity == 0)
                                <a class="text-[18px] font-light max-sm:text-[12px] sn-color-danger" href="{{route('shop.marketplace.show', $product->seller_slug)}}">
                                    {{__('marketplace::app.catalog.products.view.out_of_stock')}}
                                </a>
                                @endif



                                {!! view_render_event('bagisto.shop.products.name.before', ['product' => $product]) !!}

                                <!-- Rating -->
                                {!! view_render_event('bagisto.shop.products.rating.before', ['product' => $product]) !!}

                              
                                {!! view_render_event('bagisto.shop.products.rating.after', ['product' => $product]) !!}

                                <!-- Pricing -->
                                {!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}

                                @if($product->has_variants)
                                    @foreach($product->variants as $variant)
                                        <p class="sn-color-secondary sn-heading-2" v-if="selectedVariantId == {{$variant->id}}">
                                            {!! $product->getTypeInstance()->getPriceHtml($variant->price) !!}
                                        </p>
                                    @endforeach
                                @else
                                <p class="sn-color-secondary sn-heading-2">
                                    {!! $product->getTypeInstance()->getPriceHtml() !!}
                                </p>
                                @endif

                                {!! view_render_event('bagisto.shop.products.price.after', ['product' => $product]) !!}

                                {{!$product->seller->is_online ? "هذا التاجر مغلق الآن" : ""}}


                                {!! view_render_event('bagisto.shop.products.short_description.before', ['product' => $product]) !!}

                                <p class="mt-[25px] sn-text-body sn-color-black">
                                    {!! $product->short_description !!}
                                </p>

                                <div class="flex gap-[15px] max-w-[470px] mt-[30px] flex-wrap">
                                    @foreach($product->variants as $variant)
                                    <div :class="'border-[#F67541] border py-2 rounded-lg px-4 cursor-pointer' + (selectedVariantId == {{$variant->id}} ? ' bg-[#F67541] text-white' : '')" @click="selectedVariantId = {{$variant->id}};">
                                        {{$variant->label}}
                                    </div> 
                                    @endforeach
                                </div>


                                {!! view_render_event('bagisto.shop.products.short_description.after', ['product' => $product]) !!}

                                @include('shop::products.view.types.configurable')

                                @include('shop::products.view.types.grouped')

                                @include('shop::products.view.types.bundle')

                                @include('shop::products.view.types.downloadable')


                                <div class="mt-[20px]">
                                    <textarea 
                                        placeholder="أضف ملاحظة مع الطلب!" 
                                        name="note"
                                        class="w-full pt-4 pb-4 px-3 shadow border rounded text-[14px] text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400"
                                    />
                                </div>
        
                                <!-- Product Actions and Qunatity Box -->
                                <div class="flex gap-[15px] max-w-[470px] mt-[20px]">

                                    {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                                    @if ($product->getTypeInstance()->showQuantityBox())
                                        <x-shop::quantity-changer
                                            name="quantity"
                                            value="1"
                                            class="gap-x-[16px] max-lg:!px-[10px] sn-button-primary-alt "
                                        >
                                        </x-shop::quantity-changer>
                                    @endif

                                    {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

                                    <!-- Add To Cart Button -->
                                    {!! view_render_event('bagisto.shop.products.view.add_to_cart.before', ['product' => $product]) !!}

                                    <button
                                        type="submit"
                                        class="max-lg:!px-[20px] sn-button-primary w-full"
                                        {{ ! $product->isSaleable(1) ? 'disabled' : '' }}
                                    >
                                        @lang('shop::app.products.view.add-to-cart')
                                    </button>

                                    {!! view_render_event('bagisto.shop.products.view.add_to_cart.after', ['product' => $product]) !!}
                                </div>

                                <!-- Buy Now Button -->
                                {!! view_render_event('bagisto.shop.products.view.buy_now.before', ['product' => $product]) !!}

                                @if (core()->getConfigData('catalog.products.storefront.buy_now_button_display'))
                                    <button
                                        type="submit"
                                        class="primary-button w-full max-w-[470px] mt-[20px]"
                                        @click="is_buy_now=1;"
                                        {{ ! $product->isSaleable(1) ? 'disabled' : '' }}
                                    >
                                        @lang('shop::app.products.view.buy-now')
                                    </button>
                                @endif

                                {!! view_render_event('bagisto.shop.products.view.buy_now.after', ['product' => $product]) !!}
                            </div>
                        </div>
                    </div>
                </form>
            </x-shop::form>
        </script>

        <script type="module">
            app.component('v-product', {
                template: '#v-product-template',

                props: ['productId'],

                data() {
                    return {
                        isWishlist: Boolean(
                            "{{ (bool) auth()->guard()->user()?->wishlist_items->where('channel_id', core()->getCurrentChannel()->id)->where('product_id', $product->id)->count() }}"
                        ),

                        isCustomer: '{{ auth()->guard('customer')->check() }}',

                        is_buy_now: 0,

                        selectedVariantId: "{{ $product->has_variants ? $product->variants[0]->id : null }}",
                    }
                },

                methods: {
                    addToCart(params) {
                        let formData = new FormData(this.$refs.formData);

                        this.$axios.post('{{ route('shop.api.checkout.cart.store') }}', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(response => {
                                if (response.data.message) {
                                    this.$emitter.emit('update-mini-cart', response.data.data);

                                    this.$emitter.emit('add-flash', {
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    if (response.data.redirect) {
                                        window.location.href = response.data.redirect;
                                    }
                                } else {
                                    this.$emitter.emit('add-flash', {
                                        type: 'warning',
                                        message: response.data.data.message
                                    });
                                }
                            })
                            .catch(error => {});
                    },

                    addToWishlist() {
                        if (this.isCustomer) {
                            this.$axios.post('{{ route('shop.api.customers.account.wishlist.store') }}', {
                                    product_id: "{{ $product->id }}"
                                })
                                .then(response => {
                                    this.isWishlist = !this.isWishlist;

                                    this.$emitter.emit('add-flash', {
                                        type: 'success',
                                        message: response.data.data.message
                                    });
                                })
                                .catch(error => {});
                        } else {
                            window.location.href = "{{ route('shop.customer.session.index') }}";
                        }
                    },

                    addToCompare(productId) {
                        /**
                         * This will handle for customers.
                         */
                        if (this.isCustomer) {
                            this.$axios.post('{{ route('shop.api.compare.store') }}', {
                                    'product_id': productId
                                })
                                .then(response => {
                                    this.$emitter.emit('add-flash', {
                                        type: 'success',
                                        message: response.data.data.message
                                    });
                                })
                                .catch(error => {
                                    if ([400, 422].includes(error.response.status)) {
                                        this.$emitter.emit('add-flash', {
                                            type: 'warning',
                                            message: error.response.data.data.message
                                        });

                                        return;
                                    }

                                    this.$emitter.emit('add-flash', {
                                        type: 'error',
                                        message: error.response.data.message
                                    });
                                });

                            return;
                        }

                        /**
                         * This will handle for guests.
                         */
                        let existingItems = this.getStorageValue(this.getCompareItemsStorageKey()) ?? [];

                        if (existingItems.length) {
                            if (!existingItems.includes(productId)) {
                                existingItems.push(productId);

                                this.setStorageValue(this.getCompareItemsStorageKey(), existingItems);

                                this.$emitter.emit('add-flash', {
                                    type: 'success',
                                    message: "@lang('shop::app.products.view.add-to-compare')"
                                });
                            } else {
                                this.$emitter.emit('add-flash', {
                                    type: 'warning',
                                    message: "@lang('shop::app.products.view.already-in-compare')"
                                });
                            }
                        } else {
                            this.setStorageValue(this.getCompareItemsStorageKey(), [productId]);

                            this.$emitter.emit('add-flash', {
                                type: 'success',
                                message: "@lang('shop::app.products.view.add-to-compare')"
                            });
                        }
                    },

                    getCompareItemsStorageKey() {
                        return 'compare_items';
                    },

                    setStorageValue(key, value) {
                        localStorage.setItem(key, JSON.stringify(value));
                    },

                    getStorageValue(key) {
                        let value = localStorage.getItem(key);

                        if (value) {
                            value = JSON.parse(value);
                        }

                        return value;
                    },
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
