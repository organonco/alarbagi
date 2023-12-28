<x-shop::layouts
        :has-feature="false">
    <x-slot:title>
        {{ $seller->name}}
        </x-slot>


        {{--        <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px]">--}}
        {{--            <div class="flex justify-between items-center mt-[30px]">--}}
        {{--                <h2 class="text-[26px] font-medium">--}}
        {{--                    {{$seller->name}}--}}
        {{--                </h2>--}}
        {{--            </div>--}}
        {{--        </div>--}}



        {{-- Hero Image --}}
        @if ($seller->banner_path)
            <div class="container mt-[30px] px-[60px] max-lg:px-[30px]">
                <div>
                    <img
                            class="rounded-[12px]"
                            src="{{ $seller->banner_url }}"
                            alt="{{ $seller->name }}"
                            width="1320"
                            height="300"
                    >
                </div>
            </div>
        @endif

{{--        <div class="panel-side grid grid-cols-[1fr] max-w-[400px] min-w-[342px] max-h-[1320px] overflow-y-auto overflow-x-hidden journal-scroll pr-[26px] max-xl:min-w-[270px] mt-[30px]">--}}
{{--            --}}
{{--        </div>--}}



        <v-category>
            <x-shop::shimmer.categories.view/>
        </v-category>

        @pushOnce('scripts')
            <script
                    type="text/x-template"
                    id="v-category-template"
            >
                <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] py-[60px]">

                    <div style="display: flex; justify-content: center">
                        <div class="profile-img-wrapper">
                            <img src="{{$seller->logo_url}}" class="profile-img"/>
                        </div>
                    </div>
                    <h2 class="text-[26px] font-bold mt-[30px] text-center mb-[30px]">
                        {{$seller->name}}
                    </h2>

                    <div class="text-center mb-[30px]">
                        {{$seller->address}}
                    </div>

                    <div class="text-center mt-[30px]">
                        {{$seller->description}}
                    </div>


                    <div class="flex gap-[40px] items-start md:mt-[40px] max-lg:gap-[20px]">
                        <!-- Product Listing Filters -->
                        {{--                                            @include('shop::categories.filters')--}}



                        <!-- Product Listing Container -->
                        <div class="flex-1">

                            <div class="hidden">
                                @include('shop::categories.toolbar')
                            </div>

                            <!-- Product List Card Container -->
                            <div
                                    class="grid grid-cols-1 gap-[25px] mt-[30px]"
                                    v-if="filters.toolbar.mode === 'list'"
                            >
                                <!-- Product Card Shimmer Effect -->
                                <template v-if="isLoading">
                                    <x-shop::shimmer.products.cards.list
                                            count="12"></x-shop::shimmer.products.cards.list>
                                </template>

                                <!-- Product Card Listing -->
                                <template v-else>
                                    <template v-if="products.length">
                                        <x-shop::products.card
                                                ::mode="'list'"
                                                v-for="product in products"
                                        >
                                        </x-shop::products.card>
                                    </template>

                                    <!-- Empty Products Container -->
                                    <template v-else>
                                        <div class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
                                            <img
                                                    src="{{ bagisto_asset('images/thank-you.png') }}"
                                                    alt="placeholder"
                                            />

                                            <p class="text-[20px]">
                                                @lang('shop::app.categories.view.empty')
                                            </p>
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <!-- Product Grid Card Container -->
                            <div v-else class="mt-[30px]">
                                <!-- Product Card Shimmer Effect -->
                                <template v-if="isLoading">
                                    <div class="grid grid-cols-6 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                        <x-shop::shimmer.products.cards.grid
                                                count="12"></x-shop::shimmer.products.cards.grid>
                                    </div>
                                </template>

                                <!-- Product Card Listing -->
                                <template v-else>
                                    <template v-if="products.length">
                                        <div class="grid grid-cols-6 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                            <x-shop::products.card
                                                    ::mode="'grid'"
                                                    v-for="product in products"
                                            >
                                            </x-shop::products.card>
                                        </div>
                                    </template>

                                    <!-- Empty Products Container -->
                                    <template v-else>
                                        <div class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
                                            <img
                                                    src="{{ bagisto_asset('images/thank-you.png') }}"
                                                    alt="placeholder"
                                            />

                                            <p class="text-[20px]">
                                                @lang('shop::app.categories.view.empty')
                                            </p>
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <!-- Load More Button -->
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
            </script>

            <script type="module">
                app.component('v-category', {
                    template: '#v-category-template',

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

                            this.$axios.get("{{ route('shop.api.products.index', ['seller_id' => $seller->id]) }}", {
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
                            Object.keys(params).forEach(function (key) {
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
                .profile-img-wrapper {
                    overflow: hidden;
                    display: inline-block;
                    border: 1px solid black;
                    border-radius: 50%;
                }

                .profile-img {
                    width: 200px;
                    height: auto;
                    margin: 40px;
                }
            </style>
    @endpush
</x-shop::layouts>