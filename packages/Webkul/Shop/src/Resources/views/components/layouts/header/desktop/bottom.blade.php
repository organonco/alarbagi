<div
    class="w-full flex justify-between px-[60px] py-[10px] border border-t-0 border-b-[0px] border-l-0 border-r-0 max-1180:px-[30px] sn-background-primary">
    <v-desktop-category>
        <div class="flex gap-[20px] items-center">
            <span class="shimmer w-[80px] h-[24px] rounded-[4px]"></span>
            <span class="shimmer w-[80px] h-[24px] rounded-[4px]"></span>
            <span class="shimmer w-[80px] h-[24px] rounded-[4px]"></span>
        </div>
    </v-desktop-category>
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-desktop-category-template">
    
        <div
            class="w-full py-3 max-xl:grid-cols-4 grid-cols-5 grid"
        >
            <div
                class=" group sn-color-light-main align-middle items-center"
            >
                <span>
                    <a
                        href="{{route('offer.index')}}"
                        class="sn-button-primary-alt sn-button-mini sn-color-white"
                    >
                        {{trans('shop::app.components.layouts.header.new-offers')}}
                    </a>
                </span>
            </div>
            
            <div class="flex content-start col-span-3 gap-8 max-xl:col-span-2">
                <div
                    class="relative group border-b-[4px] border-transparent hover:border-b-[4px] hover:border-primary sn-color-white"
                    v-for="category in categories"
                >
                    <span>
                        <a
                            :href="category.url"
                            class="inline-block sn-color-white"
                            v-text="category.name"
                        >
                        </a>
                    </span>

                    <div
                        class="w-max absolute top-[30px] max-h-[580px] max-w-[1260px] p-[35px] z-[1] overflow-auto overflow-x-auto bg-white shadow-[0_6px_6px_1px_rgba(0,0,0,.3)] border border-b-0 border-l-0 border-r-0 border-t-[1px] border-[#F3F3F3] pointer-events-none opacity-0 transition duration-300 ease-out translate-y-1 group-hover:pointer-events-auto group-hover:opacity-100 group-hover:translate-y-0 group-hover:ease-in group-hover:duration-200 ltr:-left-[35px] rtl:-right-[35px]"
                        v-if="category.children.length"
                    >
                        <div class="flex aigns gap-x-[70px] justify-between">
                            <div
                                class="grid grid-cols-[1fr] gap-[20px] content-start w-full flex-auto min-w-max max-w-[150px]"
                                v-for="pairCategoryChildren in pairCategoryChildren(category)"
                            >
                                <template v-for="secondLevelCategory in pairCategoryChildren">
                                    <p class="text-navyBlue font-medium">
                                        <a
                                            :href="secondLevelCategory.url"
                                            v-text="secondLevelCategory.name"
                                        >
                                        </a>
                                    </p>

                                    <ul
                                        class="grid grid-cols-[1fr] gap-[12px]"
                                        v-if="secondLevelCategory.children.length"
                                    >
                                        <li
                                            class="text-[14px] font-medium text-[#6E6E6E]"
                                            v-for="thirdLevelCategory in secondLevelCategory.children"
                                        >
                                            <a
                                                :href="thirdLevelCategory.url"
                                                v-text="thirdLevelCategory.name"
                                            >
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row items-end content-end justify-end">
                    <a
                        href="{{route('shop.customers.register.index-seller')}}"
                        class="sn-color-white flex flex-row gap-6"
                    >
                        {{trans('shop::app.components.layouts.header.download-app')}}
                        <img src="{{ asset('assets/images/icons/logo.png') }}" style="width: 40px">
                    </a>
            </div>

            
        </div>
    </script>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return {
                    isLoading: true,

                    categories: [],
                }
            },

            mounted() {
                this.get();
            },

            methods: {
                get() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.isLoading = false;

                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                pairCategoryChildren(category) {
                    return category.children.reduce((result, value, index, array) => {
                        if (index % 2 === 0) {
                            result.push(array.slice(index, index + 2));
                        }

                        return result;
                    }, []);
                }
            },
        });
    </script>
@endPushOnce
