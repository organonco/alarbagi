<div class="gap-[10px] flex-wrap p-[10px] hidden max-lg:flex sn-background-light-main">
    <div class="w-full flex justify-center items-center">
        {{-- Left Navigation --}}

        {{-- <div class="flex items-center gap-x-[5px]">
            <x-shop::drawer position="left" width="80%">
                <x-slot:toggle>
                    <span class="icon-hamburger text-[24px] cursor-pointer sn-color-primary"></span>
                </x-slot:toggle>

                <x-slot:content>
                    <div class="flex flex-col justify-between h-full">
                        <div>
                            <div
                                class="grid grid-cols-[auto_1fr] gap-[15px] items-center p-[10px] border-b border-[#E9E9E9]  mt-12">
                                <div class="">
                                    <img src="{{ auth()->user()?->image_url ?? bagisto_asset('images/user-placeholder.png') }}"
                                        class="w-[60px] h-[60px] rounded-full">
                                </div>
                                @guest('customer')
                                    <a href="{{ route('shop.customer.session.create') }}"
                                        class="flex text-center sn-color-secondary sn-heading-3 ">
                                        @lang('shop::app.components.layouts.header.sign-in')
                                    </a>
                                @endguest
                                @auth('customer')
                                    <div class="flex flex-col gap-[4px] justify-between">
                                        <p class="text-[16px] font-mediums">أهلاً بك {{ auth()->user()?->first_name }}!</p>
                                        <a href="{{ route('shop.customers.account.profile.index') }}"
                                            class="text-[#6E6E6E] ">اعدادات الحساب</a>
                                    </div>
                                @endauth
                            </div>
                            <div class="grid grid-cols-[auto_1fr] gap-[15px] items-center p-[10px] border-b">
                                <div class="">
                                    <img src="{{ asset('assets/images/icons/cart-with-background.png') }}"
                                        class="w-[60px] h-[60px] rounded-full">
                                </div>
                                <a href="{{ route('shop.checkout.cart.index') }}"
                                    class="flex text-center sn-color-secondary sn-heading-3 ">
                                    العربة
                                </a>
                            </div>

							<div class="grid grid-cols-[auto_1fr] gap-[15px] items-center p-[10px] border-b">
                                <div class="">
                                    <img src="{{ asset('assets/images/icons/heart-with-background.png') }}"
                                        class="w-[60px] h-[60px] rounded-full">
                                </div>
                                <a href="{{ route('shop.customers.account.wishlist.index') }}"
                                    class="flex text-center sn-color-secondary sn-heading-3 ">
                                    المفضلة
                                </a>
                            </div>


                        </div>

                        <div>
                            <div class="flex justify-center w-full p-12">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </div>
                        </div>
                    </div>
                </x-slot:content>
                <x-slot:footer></x-slot:footer>
            </x-shop::drawer>
        </div> --}}

        <a href="{{ route('shop.home.index') }}">
            <img src="{{ core()->getCurrentChannel()->logo_url ?? asset('assets/images/logo.png') }}" alt="Logo"
                width="160" height="29">
        </a>
        <div class="flex items-center gap-x-[5px]">
        </div>
    </div>

    {{-- Serach Catalog Form --}}
    @if (!\Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'shop.customers'))
        <form action="{{ route('shop.search.index') }}" class="flex items-center w-full">
            <label for="organic-search" class="sr-only">Search</label>

            <div class="relative w-full">
                <div
                    class="icon-search flex items-center absolute left-[12px] top-[12px] text-[25px] pointer-events-none">
                </div>

                <input type="text"
                    class="block w-full px-11 py-3.5 border border-['#E3E3E3'] rounded-xl text-gray-900 text-xs font-medium"
                    name="query" value="{{ request('query') }}" placeholder="@lang('shop::app.components.layouts.header.search-text')" required>
            </div>
        </form>
    @endif
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-mobile-category-template">
        <div class="px-3">
            {{-- <div class="flex justify-between items-center border border-b-[1px] border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">

                <a
                    href="{{route('shop.customers.register.index-seller')}}"
                    class="flex items-center justify-between pb-[20px] mt-[20px]"
                >
                    {{trans('marketplace::app.register.title.seller')}}
                </a>

            </div> --}}

            <template v-for="(category) in categories">
                <a
                    :href="category.url" class="flex justify-between items-center border border-b-[1px] border-l-0 border-r-0 border-t-0 border-[#f3f3f5]"    >
                    <div
                                class="flex items-center justify-between pb-[20px] mt-[20px]"
                                v-text="category.name"
                        >
                    </div>
                    <span
                            class="text-[24px] cursor-pointer"
                            :class="{'icon-arrow-down': category.isOpen, 'icon-arrow-left': ! category.isOpen}"
                    >
                    </span>
                </a>

                <div
                        class="grid gap-[8px]"
                        v-if="category.isOpen"
                >
                    <ul v-if="category.children.length">
                        <li v-for="secondLevelCategory in category.children">
                            <div class="flex justify-between items-center ml-3 border border-b-[1px] border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">
                                <a
                                        :href="secondLevelCategory.url"
                                        class="flex items-center justify-between pb-[20px] mt-[20px]"
                                        v-text="secondLevelCategory.name"
                                >
                                </a>

                                <span
                                        class="text-[24px] cursor-pointer"
                                        :class="{
                                        'icon-arrow-down': secondLevelCategory.category_show,
                                        'icon-arrow-right': ! secondLevelCategory.category_show
                                    }"
                                        @click="secondLevelCategory.category_show = ! secondLevelCategory.category_show"
                                >
                                </span>
                            </div>

                            <div v-if="secondLevelCategory.category_show">
                                <ul v-if="secondLevelCategory.children.length">
                                    <li v-for="thirdLevelCategory in secondLevelCategory.children">
                                        <div class="flex justify-between items-center ml-3 border border-b-[1px] border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">
                                            <a
                                                    :href="thirdLevelCategory.url"
                                                    class="flex items-center justify-between mt-[20px] ml-3 pb-[20px]"
                                                    v-text="thirdLevelCategory.name"
                                            >
                                            </a>
                                        </div>
                                    </li>
                                </ul>

                                <span
                                        class="ml-2"
                                        v-else
                                >
                                    @lang('No category found.')
                                </span>
                            </div>
                        </li>
                    </ul>

                    <span
                            class="ml-2"
                            v-else
                    >
                        @lang('No category found.')
                    </span>
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-mobile-category', {
            template: '#v-mobile-category-template',

            data() {
                return {
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
                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                toggle(selectedCategory) {
                    this.categories = this.categories.map((category) => ({
                        ...category,
                        isOpen: category.id === selectedCategory.id ? !category.isOpen : false,
                    }));
                },
            },
        });
    </script>
@endPushOnce
