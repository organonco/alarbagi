<div
    class="flex justify-between items-center w-full py-[11px] px-16 border border-t-0 border-b-[1px] border-l-0 border-r-0 gap-x-[35px] max-lg:gap-x-[30px] max-[1100px]:gap-x-[25px] sn-background-light-main">

    <a
        href="{{ route('shop.home.index') }}"
        class="place-self-start -mt-[4px]"
        aria-label="Bagisto "
    >
        <img
            src="{{ core()->getCurrentChannel()->logo_url ?? asset('assets/images/logo.png') }}"
            width="300"
            alt="Logo"
            style="margin: 0.2rem"
        >
    </a>

    {{-- Search Bar Container --}}
    <form
        action="{{ route('shop.search.index') }}"
        class="w-full"
    >
        <label
            for="organic-search"
            class="sr-only"
        >
            @lang('shop::app.components.layouts.header.search')
        </label>

        <div class="relative w-full">
            <div
                class="icon-search flex items-center  absolute ltr:left-[12px] rtl:right-[12px] top-[10px] text-[22px] pointer-events-none"></div>
            <input
                type="text"
                name="query"
                value="{{ request('query') }}"
                class="block w-full px-[44px] py-[13px] bg-[#F5F5F5] rounded-lg text-gray-900 text-xs font-medium transition-all border border-transparent hover:border-gray-400 focus:border-gray-400"
                placeholder="@lang('shop::app.components.layouts.header.search-text')"
                required
            >

            @if (core()->getConfigData('general.content.shop.image_search'))
{{--                @include('shop::search.images.index')--}}
            @endif
        </div>
    </form>

    <div class="flex gap-x-[35px] mt-[5px] max-lg:gap-x-[30px] max-[1100px]:gap-x-[25px]">

        {{-- Mini cart --}}
        @include('shop::checkout.cart.mini-cart')


        @auth('customer')
        <a
                href="{{ route('shop.customers.account.wishlist.index') }}"
        >
            <span class="icon-heart inline-block text-[24px] cursor-pointer"></span>
        </a>
        @endauth

        {{-- user profile --}}
        <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
            <x-slot:toggle>
                <span class="icon-users inline-block text-[24px] cursor-pointer"></span>
            </x-slot:toggle>

            {{-- Guest Dropdown --}}
            @guest('customer')
                <x-slot:content>
                    <div class="grid gap-[10px]">
                        <p class="text-[20px] font-dmserif">
                            @lang('shop::app.components.layouts.header.welcome-guest')
                        </p>

                        <p class="text-[14px]">
                            @lang('shop::app.components.layouts.header.dropdown-text')
                        </p>
                    </div>

                    <p class="w-full mt-[12px] py-2px border border-[#E9E9E9]"></p>

                    <div class="flex gap-[16px] mt-[25px]">
                        <a
                            href="{{ route('shop.customer.session.create') }}"
                            class="sn-button-primary"
                        >
                            @lang('shop::app.components.layouts.header.sign-in')
                        </a>

                        <a
                            href="{{ route('shop.customers.register.index') }}"
                            class="sn-button-secondary"
                        >
                            @lang('shop::app.components.layouts.header.sign-up')
                        </a>
                    </div>
                </x-slot:content>
            @endguest

            {{-- Customers Dropdown --}}
            @auth('customer')
                <x-slot:content class="!p-[0px]">
                    <div class="grid gap-[10px] p-[20px] pb-0">
                        <p class="text-[20px] font-dmserif">
                            @lang('shop::app.components.layouts.header.welcome')’
                            {{ auth()->guard('customer')->user()->first_name }}
                        </p>

                        <p class="text-[14px]">
                            @lang('shop::app.components.layouts.header.dropdown-text')
                        </p>
                    </div>

                    <p class="w-full mt-[12px] py-2px border border-[#E9E9E9]"></p>

                    <div class="grid gap-[4px] mt-[10px] pb-[10px]">
                        <a
                            class="px-5 py-2 text-[16px] hover:bg-gray-100 cursor-pointer"
                            href="{{ route('shop.customers.account.profile.index') }}"
                        >
                            @lang('shop::app.components.layouts.header.profile')
                        </a>

                        <a
                            class="px-5 py-2 text-[16px] hover:bg-gray-100 cursor-pointer"
                            href="{{ route('shop.customers.account.orders.index') }}"
                        >
                            @lang('shop::app.components.layouts.header.orders')
                        </a>

                        @if (core()->getConfigData('general.content.shop.wishlist_option'))
                            <a
                                class="px-5 py-2 text-[16px] hover:bg-gray-100 cursor-pointer"
                                href="{{ route('shop.customers.account.wishlist.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.wishlist')
                            </a>
                        @endif

                        {{--Customers logout--}}
                        @auth('customer')
                            <x-shop::form
                                method="DELETE"
                                action="{{ route('shop.customer.session.destroy') }}"
                                id="customerLogout"
                            >
                            </x-shop::form>

                            <a
                                class="px-5 py-2 text-[16px] hover:bg-gray-100 cursor-pointer"
                                href="{{ route('shop.customer.session.destroy') }}"
                                onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                            >
                                @lang('shop::app.components.layouts.header.logout')
                            </a>
                        @endauth
                    </div>
                </x-slot:content>
            @endauth
        </x-shop::dropdown>
    </div>
    <x-shop::dropdown position="bottom-right">
        <x-slot:toggle>
            {{-- Dropdown Toggler --}}
            <div class="flex items-center gap-[10px] cursor-pointer">
                <img
                    src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                            ? core()->getCurrentLocale()->logo_url
                            : bagisto_asset('images/default-language.svg')
                        }}"
                    class="h-full"
                    alt="Default locale"
                    width="24"
                    height="16"
                />

                <span>
                    {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                </span>

                <span class="icon-arrow-down text-[24px]"></span>
            </div>
        </x-slot:toggle>

        <!-- Dropdown Content -->
        <x-slot:content class="!p-[0px]">
            <v-locale-switcher></v-locale-switcher>
        </x-slot:content>
    </x-shop::dropdown>
</div>

@pushonce('scripts')

    <script type="text/x-template" id="v-currency-switcher-template">
        <div class="grid gap-[4px] mt-[10px] pb-[10px]">
            <span
                class="px-5 py-2 text-[16px] cursor-pointer hover:bg-gray-100"
                v-for="currency in currencies"
                :class="{'bg-gray-100': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                @click="change(currency)"
            >
                @{{ currency.symbol + ' ' + currency.code }}
            </span>
        </div>
    </script>

    <script type="text/x-template" id="v-locale-switcher-template">
        <div class="grid gap-[4px] mt-[10px] pb-[10px]">
            <span
                class="flex items-center gap-[10px] px-5 py-2 text-[16px] cursor-pointer hover:bg-gray-100"
                v-for="locale in locales"
                :class="{'bg-gray-100': locale.code == '{{ app()->getLocale() }}'}"
                @click="change(locale)"
            >
                <img
                    :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                    width="24"
                    height="16"
                />

                @{{ locale.name }}
            </span>
        </div>
    </script>

    <script type="module">
        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('currency', currency.code);

                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('locale', locale.code);

                    window.location.href = url.href;
                }
            }
        });
    </script>
@endpushonce
