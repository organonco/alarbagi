<x-shop::layouts
    :has-feature="false">
    <x-slot:title>
        {{ config('app.name') }}
    </x-slot:title>

    <v-category>
        <x-shop::shimmer.categories.view/>
    </v-category>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-category-template"
        >
            <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] py-[60px]">

                <div class="flex gap-[40px] items-start md:mt-[40px] max-lg:gap-[20px]">
                    <div class="flex-1">
                        @include('shop::categories.toolbar')
                        <div
                            class="grid grid-cols-1 gap-[25px] mt-[30px]"
                            v-if="filters.toolbar.mode === 'list'"
                        >
                            <template v-if="isLoading">
                                <x-shop::shimmer.products.cards.list
                                    count="12"></x-shop::shimmer.products.cards.list>
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
                                    <div
                                        class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
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
                                <div
                                    class="grid grid-cols-6 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                    <x-shop::shimmer.products.cards.grid
                                        count="12"></x-shop::shimmer.products.cards.grid>
                                </div>
                            </template>

                            <!-- Product Card Listing -->
                            <template v-else>
                                <template v-if="products.length">
                                    <div
                                        class="grid grid-cols-6 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px]">
                                        <x-shop::products.card
                                            ::mode="'grid'"
                                            v-for="product in products"
                                        >
                                        </x-shop::products.card>
                                    </div>
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div
                                        class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[476px] text-center">
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

                },

                mounted: function() {
                    this.getProducts()
                },

                watch: {
                },

                methods: {

                    getProducts() {
                        this.isDrawerActive = {
                            toolbar: false,

                            filter: false,
                        };

                        this.$axios.get("{{ route('shop.api.products.index', $filters) }}".replace(/&amp;/g, '&') , {
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

                },
            });
        </script>
    @endPushOnce

    @push('styles')
        <style>
            .profile-img-wrapper {
                overflow: hidden;
                display: inline-block;
                border: 1px solid #EFEFEF;
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
