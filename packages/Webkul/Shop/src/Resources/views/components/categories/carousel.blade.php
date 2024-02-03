<v-categories-carousel
    src="{{ $src }}"
    title="{{ $title }}"
    navigation-link="{{ $navigationLink ?? '' }}"
>
    <x-shop::shimmer.categories.carousel
        :count="8"
        :navigation-link="$navigationLink ?? false"
    ></x-shop::shimmer.categories.carousel>
</v-categories-carousel>

@pushOnce('scripts')
    <script type="text/x-template" id="v-categories-carousel-template">
        <div class="container mt-[60px] max-lg:px-[30px] max-sm:mt-[20px]" v-if="! isLoading && categories?.length">
            <div class="relative">
                <div
                    ref="swiperContainer"
                    class="flex gap-10 overflow-auto scroll-smooth scrollbar-hide max-sm:gap-4 gap-05-mobile"
                >
                    <div
                        class="grid grid-cols-1 gap-[15px] justify-items-center min-w-[110px] max-w-[110px] font-medium"
                        v-for="category in categories"
                    >
                        <a
                            :href="category.url_path"
                            class="w-[110px] h-[110px] bg-[#F5F5F5] rounded-full categories-carousel"
                            :aria-label="category.name"
                        >
                            <template v-if="category.images.logo_url">
                                <x-shop::media.images.lazy
                                    ::src="category.images.logo_url"
                                    width="110"
                                    height="110"
                                    class="w-[110px] h-[110px] rounded-full categories-carousel"
                                    style="border: 1px solid #AFAFAF"
                                    ::alt="category.name"
                                ></x-shop::media.images.lazy>
                            </template>
                        </a>

                        <a
                            :href="category.url_path"
                            class=""
                        >
                            <p
                                class="text-center sn-color-secondary text-[18px] max-sm:font-normal categories-carousel-text"
                                style=""
                                v-text="category.name"
                            >
                            </p>
                        </a>
                    </div>
                </div>

                <span
                    class="flex items-center justify-center absolute top-[37px] -left-[41px] w-[50px] h-[50px] bg-white border border-black rounded-full transition icon-arrow-left text-[25px] hover:text-white max-lg:-left-[29px] cursor-pointer phone-hidden sn-color-light-main sn-border-main"
                    @click="swipeLeft"
                >
                </span>

                <span
                    class="flex items-center justify-center absolute top-[37px] -right-[22px] w-[50px] h-[50px] bg-white border border-black rounded-full transition icon-arrow-right text-[25px] hover:text-white max-lg:-right-[29px] cursor-pointer phone-hidden sn-color-light-main sn-border-main"
                    @click="swipeRight"
                >
                </span>
            </div>
        </div>

        <!-- Category Carousel Shimmer -->
        <template v-if="isLoading">
            <x-shop::shimmer.categories.carousel
                :count="8"
                :navigation-link="$navigationLink ?? false"
            >
            </x-shop::shimmer.categories.carousel>
        </template>
    </script>

    <script type="module">
        app.component('v-categories-carousel', {
            template: '#v-categories-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

            data() {
                return {
                    isLoading: true,

                    categories: [],

                    offset: 323,
                };
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.categories = response.data.data;
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
