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
                    <span
                        class="icon-arrow-left rtl:icon-arrow-right inline-block text-[40px] cursor-pointer sn-color-light-main"
                        @click="swipeLeft"
                    >
                    </span>

                    <span
                        class="icon-arrow-right rtl:icon-arrow-left inline-block text-[40px] cursor-pointer sn-color-light-main"
                        @click="swipeRight"
                    >
                    </span>
                </div>
            </div>

            <div
                ref="swiperContainer"
                class="flex gap-8 [&>*]:flex-[0] mt-[40px] overflow-auto scroll-smooth scrollbar-hide max-sm:mt-[20px]"
            >
                <x-shop::products.card
                    class="min-w-[291px]"
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
