<v-products-carousel
    src="{{ $src }}"
    title="{{ $title }}"
    navigation-link="{{ $navigationLink ?? '' }}"
>
    <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false"></x-shop::shimmer.products.carousel>
</v-products-carousel>

@pushOnce('scripts')
    <script type="text/x-template" id="v-products-carousel-template">
        <div class="container mt-20 max-lg:px-[30px] max-sm:mt-[30px]" v-if="! isLoading && products.length">
            <div class="flex justify-between">
                <h3 class="text-[30px] font-dmserif max-sm:text-[25px] sn-color-light-main" v-text="title"></h3>

                <div class="flex gap-8 justify-between items-center">
                </div>
            </div>

            <div
                ref=""
                class="grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-sm:justify-items-center max-sm:gap-[16px] mt-[40px] max-sm:mt-[20px]"
            >
                <x-shop::products.card
                    ::mode="'grid'"
                    v-for="product in products"
                >
                </x-shop::products.card>
            </div>

            <a
                :href="navigationLink"
                class="sn-button-primary block w-max mt-[60px] mx-auto py-[11px] rounded-[18px]"
                v-if="navigationLink"
            >
                @lang('shop::app.components.products.carousel.view-all')
            </a>
        </div>

        <!-- Product Card Listing -->
        <template v-if="isLoading">
            <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false"></x-shop::shimmer.products.carousel>
        </template>
    </script>

    <script type="module">
        app.component('v-products-carousel', {
            template: '#v-products-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

            data() {
                return {
                    isLoading: true,

                    products: [],

                    offset: 323,
                };
            },

            mounted() {
                this.getProducts();
            },

            methods: {
                getProducts() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.products = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;

                    container.scrollLeft -= this.offset;
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;

                    container.scrollLeft += this.offset;
                },
            },
        });
    </script>
@endPushOnce
