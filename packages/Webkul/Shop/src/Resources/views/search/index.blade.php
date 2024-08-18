{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.search.title', ['query' => request()->query('query')])" />

    <meta name="keywords" content="@lang('shop::app.search.title', ['query' => request()->query('query')])" />
@endPush

<x-shop::layouts :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.search.title', ['query' => request()->query('query')])
    </x-slot>

    <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px]">
        @if (request()->has('image-search'))
            @include('shop::search.images.results')
        @endif

        <div class="flex justify-between items-center mt-[30px]">
            <h2 class="text-[26px] font-medium">
                @lang('shop::app.search.title', ['query' => request()->query('query')])
            </h2>
        </div>
    </div>

    {{-- Product Listing --}}
    <v-search>
        <x-shop::shimmer.categories.view />
    </v-search>

    @pushOnce('scripts')
        <script 
            type="text/x-template" 
            id="v-search-template"
        >
            <div class="container px-[0px] max-lg:px-[30px] max-sm:px-[15px]">
                <div class="tabs">
                    <div class="tab-2">
                        <label for="tab2-1" class="sn-heading-3">المنتجات</label>
                        <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
                        <div>
                            <div class="flex gap-[40px] items-start md:mt-[40px] max-lg:gap-[20px]">
                                {{-- @include('shop::categories.filters') --}}
                                <div class="flex-1">
                                    <div class="max-md:hidden">
                                        @include('shop::categories.toolbar')
                                    </div>
                                    <div
                                        class="grid grid-cols-1 gap-[25px] mt-[30px]"
                                        v-if="filters.toolbar.mode === 'list'"
                                    >
                                        <template v-if="isLoading">
                                            <x-shop::shimmer.products.cards.list count="12"></x-shop::shimmer.products.cards.list>
                                        </template>
                                        <template v-else>
                                            <template v-if="products.length">
                                                <x-shop::products.card
                                                    ::mode="'list'"
                                                    v-for="product in products"
                                                >
                                                </x-shop::products.card>
                                            </template>
                                            <template v-else>
                                                <div class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
                                                    <img src="{{ bagisto_asset('images/thank-you.png') }}"/>
                                            
                                                    <p class="text-[20px]">
                                                        @lang('shop::app.categories.view.empty')
                                                    </p>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                    <div v-else>
                                        <template v-if="isLoading">
                                            <div class="grid grid-cols-3 gap-8 mt-[30px] max-sm:mt-[20px] max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                                <x-shop::shimmer.products.cards.grid count="12"></x-shop::shimmer.products.cards.grid>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <template v-if="products.length">
                                                <div class="grid grid-cols-3 gap-8 mt-[30px] max-sm:mt-[20px] max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                                    <x-shop::products.card
                                                        ::mode="'grid'"
                                                        v-for="product in products"
                                                    >
                                                    </x-shop::products.card>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
                                                    <img src="{{ bagisto_asset('images/thank-you.png') }}"/>
                                                    <p class="text-[20px]">
                                                        @lang('shop::app.categories.view.empty')
                                                    </p>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                    <button
                                        class="secondary-button block mx-auto w-max py-[11px] mt-[60px] px-[43px] rounded-[18px] text-base text-center"
                                        @click="loadMoreProducts"
                                        v-if="links.next"
                                    >
                                        @lang('shop::app.categories.view.load-more')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-2">
                        <label for="tab2-2" class="sn-heading-3">البائعين</label>
                        <input id="tab2-2" name="tabs-two" type="radio">
                        <div>
                            <div class="flex gap-[40px] items-start md:mt-[40px] max-lg:gap-[20px]">
                                @if($sellers->count() > 0)
                                <div class="flex gap-6 px-4 py-18 flex-wrap justify-center max-lg:px-6">
									@foreach ($sellers as $seller)
									<a href="{{ route('shop.marketplace.show', ['slug' => $seller->slug]) }}"
										class="w-72 py-8 max-lg:py-1 flex gap-4 flex-col max-lg:gap-2 max-lg:w-24">
										<img src="{{ $seller->logo_url }}" class="w-72 h-72 rounded-lg max-lg:h-24">
										<div class="sn-color-primary text-center lg:!text-3xl max-lg:!text-xl max-lg:!font-normal">
											{{ $seller->name }}
										</div>
									</a>
								@endforeach
                                </div>
                                @else
                                <div class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
                                    <img src="{{ bagisto_asset('images/thank-you.png') }}"/>
                                    <p class="text-[20px]">
                                        @lang('shop::app.categories.view.empty-sellers')
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>
        <script type="module">
            app.component('v-search', {
                template: '#v-search-template',

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,

                        isLoading: true,

                        isDrawerActive: {
                            toolbar: false,

                            filter: false,
                        },

                        filters: {
                            toolbar: {},

                            filter: {},
                        },

                        products: [],

                        links: {},
                    }
                },

                computed: {
                    queryParams() {
                        let queryParams = Object.assign({}, this.filters.filter, this.filters.toolbar);

                        return this.removeJsonEmptyValues(queryParams);
                    },

                    queryString() {
                        return this.jsonToQueryString(this.queryParams);
                    },
                },

                watch: {
                    queryParams() {
                        this.getProducts();
                    },

                    queryString() {
                        window.history.pushState({}, '', '?' + this.queryString);
                    },
                },

                methods: {
                    setFilters(type, filters) {
                        this.filters[type] = filters;
                    },

                    clearFilters(type, filters) {
                        this.filters[type] = {};
                    },

                    getProducts() {
                        this.isDrawerActive = {
                            toolbar: false,

                            filter: false,
                        };

                        this.$axios.get(("{{ route('shop.api.products.index', ['name' => request('query')]) }}"), {
                                params: this.queryParams
                            })
                            .then(response => {
                                this.isLoading = false;

                                this.products = response.data.data;

                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },

                    loadMoreProducts() {
                        if (this.links.next) {
                            this.$axios.get(this.links.next).then(response => {
                                this.products = [...this.products, ...response.data.data];

                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                        }
                    },

                    removeJsonEmptyValues(params) {
                        Object.keys(params).forEach(function(key) {
                            if ((!params[key] && params[key] !== undefined)) {
                                delete params[key];
                            }

                            if (Array.isArray(params[key])) {
                                params[key] = params[key].join(',');
                            }
                        });

                        return params;
                    },

                    jsonToQueryString(params) {
                        let parameters = new URLSearchParams();

                        for (const key in params) {
                            parameters.append(key, params[key]);
                        }

                        return parameters.toString();
                    }
                },
            });
        </script>
    @endPushOnce
    @push('styles')
        <style>
            button:focus,
            input:focus,
            textarea:focus,
            select:focus {
                outline: none;
            }

            .tabs {
                display: block;
                display: -webkit-flex;
                display: -moz-flex;
                display: flex;
                -webkit-flex-wrap: wrap;
                -moz-flex-wrap: wrap;
                flex-wrap: wrap;
                margin: 0;
                overflow: hidden;
            }

            .tabs [class^="tab"] label,
            .tabs [class*=" tab"] label {
                color: #153939;
                cursor: pointer;
                display: block;
                font-size: 1.1em;
                font-weight: 300;
                line-height: 1em;
                padding: 2rem 0;
                text-align: center;
            }

            .tabs [class^="tab"] [type="radio"],
            .tabs [class*=" tab"] [type="radio"] {
                border-bottom: 1px solid #b7b7b7;
                cursor: pointer;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                display: block;
                width: 100%;
                -webkit-transition: all 0.3s ease-in-out;
                -moz-transition: all 0.3s ease-in-out;
                -o-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
            }

            .tabs [class^="tab"] [type="radio"]:hover,
            .tabs [class^="tab"] [type="radio"]:focus,
            .tabs [class*=" tab"] [type="radio"]:hover,
            .tabs [class*=" tab"] [type="radio"]:focus {
                border-bottom: 1px solid #F67541;
            }

            .tabs [class^="tab"] [type="radio"]:checked,
            .tabs [class*=" tab"] [type="radio"]:checked {
                border-bottom: 2px solid #F67541;
            }

            .tabs [class^="tab"] [type="radio"]:checked+div,
            .tabs [class*=" tab"] [type="radio"]:checked+div {
                opacity: 1;
            }

            .tabs [class^="tab"] [type="radio"]+div,
            .tabs [class*=" tab"] [type="radio"]+div {
                display: block;
                opacity: 0;
                padding: 2rem 0;
                width: 90%;
                -webkit-transition: all 0.3s ease-in-out;
                -moz-transition: all 0.3s ease-in-out;
                -o-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
            }

            .tabs .tab-2 {
                width: 50%;
            }

            .tabs .tab-2 [type="radio"]+div {
                width: 200%;
                margin-right: 200%;
            }

            .tabs .tab-2 [type="radio"]:checked+div {
                margin-right: 0;
            }

            .tabs .tab-2:last-child [type="radio"]+div {
                margin-right: 100%;
            }

            .tabs .tab-2:last-child [type="radio"]:checked+div {
                margin-right: -100%;
            }
        </style>
    @endpush
</x-shop::layouts>
