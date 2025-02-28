<x-shop::layouts :has-feature="false">
    <x-slot:title>
        {{ $seller->name }}
    </x-slot>


    {{-- Hero Image --}}
    @if ($seller->banner_path)
        <div class="container mt-[30px] px-[60px] max-lg:px-[30px]">
            <div>
                <img class="rounded-[12px]" src="{{ $seller->banner_url }}" alt="{{ $seller->name }}" width="1320"
                    height="300">
            </div>
        </div>
    @endif

    <v-category>
        <x-shop::shimmer.categories.view />
    </v-category>

    @pushOnce('scripts')
        <script
                    type="text/x-template"
                    id="v-category-template"
            >
                <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] py-[60px]">
					<div class="flex max-lg:flex-col-reverse justify-around content-center items-center">
						<div class="flex flex-col content-start">
							<hr class="hidden max-lg:flex"/>
							<h2 class="mt-[10px] mb-[10px] sn-color-primary sn-heading-1 max-lg:mb-[0px] max-lg:mt-8 text-center">
								{{$seller->name}}
							</h2>
							<div class="sn-heading-3 sn-color-primary text-center">
								@if(!is_null($seller->sellerCategory->parent_id))
									{{$seller->sellerCategory->parent->name}}
									-
								@endif
								<a class="sn-heading-3 sn-color-primary text-center" href="{{ route('seller-category.view', ['areaId' => $seller->area->id, 'sellerCategoryId' => $seller->sellerCategory->id]) }}" >
									{{$seller->sellerCategory->name}}
								</a>
							</div>
                            <div class="text-center mb-[30px]">
                                {{
                                    $seller->is_online 
                                    ? 'مفتوح' :
                                     'مغلق'
                                }}
                            </div>

                            <div style="background-color: #C7DDD8; padding: 10px 20px; margin: 0 -20px 10px -20px">
                                <table>
                                    <tr>
                                        <td>
                                            <svg class="w-6 h-6 sn-color-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                            </svg>
                                        </td>
                                        <td class="px-2">
                                            <p class="text-sm font-bold" style="white-space: nowrap;">أوقات الدوام</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">{{$seller->opening_time}}</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <svg class="w-6 h-6 sn-color-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                                            </svg>
                                        </td>
                                        <td class="px-2">
                                            <p class="text-sm font-bold" style="white-space: nowrap;"> أيام الدوام</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">{{$seller->opening_days}}</p>
                                        </td>
                                    </tr>
                                    @if($seller->landline)
                                    <tr>
                                        <td>
                                            <svg class="w-6 h-6 sn-color-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7.978 4a2.553 2.553 0 0 0-1.926.877C4.233 6.7 3.699 8.751 4.153 10.814c.44 1.995 1.778 3.893 3.456 5.572 1.68 1.679 3.577 3.018 5.57 3.459 2.062.456 4.115-.073 5.94-1.885a2.556 2.556 0 0 0 .001-3.861l-1.21-1.21a2.689 2.689 0 0 0-3.802 0l-.617.618a.806.806 0 0 1-1.14 0l-1.854-1.855a.807.807 0 0 1 0-1.14l.618-.62a2.692 2.692 0 0 0 0-3.803l-1.21-1.211A2.555 2.555 0 0 0 7.978 4Z"/>
                                            </svg>		
                                        </td>
                                        <td class="px-2">
                                            <p class="text-sm font-bold" style="white-space: nowrap;">رقم الأرضي</p>
                                        </td>
                                        <td>
                                            <a href="tel:{{$seller->landline}}" class="text-sm">{{$seller->landline}}</a>
                                        </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td>
                                            <svg class="w-6 h-6 sn-color-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M5 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4Zm12 12V5H7v11h10Zm-5 1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                                            </svg>			
                                        </td>
                                        <td class="px-2">
                                            <p class="text-sm font-bold" style="white-space: nowrap;">رقم الموبايل</p>
                                        </td>
                                        <td>
                                            <a href="tel:{{$seller->phone}}" class="text-sm">{{$seller->phone}}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <svg class="w-6 h-6 sn-color-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                                            </svg>
                                        </td>
                                        <td class="px-2">
                                            <p class="text-sm font-bold" style="white-space: nowrap;">العنوان</p>
                                        </td>
                                        <td>
                                            <p class="text-sm"><a href="{{route('area.view', $seller->area->id)}}" >
                                                {{$seller->area->name}}
                                            </a> - {{$seller->address}}</p>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
							<hr class="hidden max-lg:flex "/>
						</div>

						<div>
							<div style="display: flex; justify-content: center">
								<img src="{{$seller->logo_url}}" class="rounded-full w-72 h-72 max-lg:w-40 max-lg:h-40"/>
							</div>
						</div>
					</div>
					<hr class="max-lg:hidden"/>

                    <div class="flex gap-[40px] items-start md:mt-[40px] max-lg:gap-[20px]">
                        <!-- Product Listing Container -->
                        <div class="flex-1" >
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
                                    <div class="grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                        <x-shop::shimmer.products.cards.grid
                                                count="12"></x-shop::shimmer.products.cards.grid>
                                    </div>
                                </template>

                                <!-- Product Card Listing -->
                                <template v-else>
                                    <template v-if="products.length">
                                        <div class="grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
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
                                    class="sn-button-primary block mx-auto w-max mt-[60px]"
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
</x-shop::layouts>
