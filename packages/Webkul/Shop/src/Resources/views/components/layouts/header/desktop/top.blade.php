<div
    class="w-full py-[11px] px-4 border border-t-0 border-b-[1px] border-l-0 border-r-0 sn-background-grey grid-cols-3 grid">

    {{-- Search Bar Container --}}
    <div class="flex items-center ">
        <div class="w-full">
            <form action="{{ route('shop.search.index') }}">
                <label for="organic-search" class="sr-only">
                    @lang('shop::app.components.layouts.header.search')
                </label>

                <div class="relative w-full">
                    <input type="text" name="query" value="{{ request('query') }}"
                        class="w-full block px-[44px] py-[13px] sn-background-grey sn-border-primary sn-body"
                        placeholder="@lang('shop::app.components.layouts.header.search-text')" required>
                    <div
                        class="icon-search flex items-center  absolute left-[12px] top-[12px] text-[22px] pointer-events-none">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="flex items-center justify-center">
        <a href="{{ route('shop.home.index') }}" class="my-2" aria-label="Bagisto ">
            <img src="{{ asset('assets/images/logo.png') }}" width="240" alt="Logo">
        </a>
    </div>


    <div class="flex items-center gap-4 justify-end">

        <a class="flex gap-2 items-center" href="{{ route('shop.customers.account.wishlist.index') }}">
            <span class="sn-color-primary text-[16px]">@lang('shop::app.components.layouts.header.wishlist')</span>
            <img src="{{ asset('assets/images/icons/heart.png') }}" style="width: 30px">
        </a >

        @include('shop::checkout.cart.mini-cart')

        @guest('customer')
            <a class="sn-button-login flex flex-row gap-2 items-center text-center" href="{{ route('shop.customer.session.create') }}">
                @lang('shop::app.components.layouts.header.sign-in')
                <img src="{{ asset('assets/images/icons/user.png') }}" style="width: 20px; height: 20px">
            </a>
        @endguest
        @auth('customer')
            <a class="sn-button-login flex flex-row gap-2 items-center text-center" href="{{ route('shop.customers.account.profile.index') }}">
                @lang('shop::app.components.layouts.header.profile')
                <img src="{{ asset('assets/images/icons/user.png') }}" style="width: 20px; height: 20px">
            </a>
        @endauth
    </div>

</div>
