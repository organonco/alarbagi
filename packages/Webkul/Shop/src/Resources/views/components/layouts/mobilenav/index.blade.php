<div class="max-lg:grid hidden fixed bottom-0 w-full grid-cols-5 sn-background-primary pt-3 pb-2"
    style="box-shadow: 0px -1px 10px #0f2929">

    <a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{ route('shop.home.index') }}">
        <img class="w-6 h-6" src="{{ Route::currentRouteName() == 'shop.home.index' ? asset('assets/images/icons/bar/selected/main.png') : asset('assets/images/icons/bar/main.png') }}" />
        <div
            class="text-center mt-1 {{ Route::currentRouteName() == 'shop.home.index' ? 'sn-color-secondary' : 'text-white' }}">
            الرئيسية
        </div>
    </a>

    <a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{ route('offer.index') }}">
		@if(auth()->guard('customer')->user()?->hasOffersNotifications())
			<div class='sn-notification-dot'></div>
		@endif
        <img class="w-6 h-6"
            src="{{ Route::currentRouteName() == 'offer.index' ? asset('assets/images/icons/bar/selected/offers.png') : asset('assets/images/icons/bar/offers.png') }}" />
        <div
            class="text-center mt-1 {{ Route::currentRouteName() == 'offer.index' ? 'sn-color-secondary' : 'text-white' }}">
            العروض
        </div>
    </a>

    <a class="flex flex-col items-center px-1 border-l sn-border-color-primary"
        href="{{ route('shop.customers.account.orders.index') }}">
        <img class="w-6 h-6"
            src="{{ Route::currentRouteName() == 'shop.customers.account.orders.index' ? asset('assets/images/icons/bar/selected/orders.png') : asset('assets/images/icons/bar/orders.png') }}" />
        <div
            class="text-center mt-1 {{ Route::currentRouteName() == 'shop.customers.account.orders.index' ? 'sn-color-secondary' : 'text-white' }}">
            الطلبات
        </div>
    </a>

    <a class="flex flex-col items-center px-1 border-l sn-border-color-primary"
        href="{{ route('shop.customers.account.wishlist.index') }}">
        <img class="w-6 h-6"
            src="{{ Route::currentRouteName() == 'shop.customers.account.wishlist.index' ? asset('assets/images/icons/bar/selected/heart.png') : asset('assets/images/icons/bar/heart.png') }}" />
        <div
            class="text-center mt-1  {{ Route::currentRouteName() == 'shop.customers.account.wishlist.index' ? 'sn-color-secondary' : 'text-white' }}">
            المفضلة
        </div>
    </a>

    <a class="flex flex-col items-center px-1 " href="{{ route('shop.customers.account.profile.index') }}">
		@if(auth()->guard('customer')->user()?->hasAccountNotifications())
			<div class='sn-notification-dot'></div>
		@endif
        <img class="w-6 h-6"
            src="{{ Route::currentRouteName() == 'shop.customers.account.profile.index' ? asset('assets/images/icons/bar/selected/user.png') : asset('assets/images/icons/bar/user.png') }}" />
        <div
            class="text-center mt-1 {{ Route::currentRouteName() == 'shop.customers.account.profile.index' ? 'sn-color-secondary' : 'text-white' }}">
            الحساب
        </div>
    </a>
</div>
</div>
