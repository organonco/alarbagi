<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="false"
>
    {{-- Page Title --}}
    <x-slot:title>
		@lang('shop::app.checkout.success.thanks')
    </x-slot>

	<div class="absolute top-[60%] left-[50%] -translate-x-[50%] -translate-y-[60%]">
		<div class="grid gap-y-[20px] place-items-center max-w-sm">
			<img 
				class="" 
				src="{{ bagisto_asset('images/thank-you.png') }}" 
				alt="thankyou" 
				title=""
			>

			<p class="text-[26px] font-medium max-lg:text-[18px]">
				@lang('shop::app.checkout.success.thanks')
			</p>

			<a href="{{ route('shop.home.index') }}">
				<div class="block w-max mx-auto m-auto sn-button-primary">
             		@lang('shop::app.checkout.cart.index.continue-shopping')
				</div> 
			</a>
			
			
		</div>
	</div>
</x-shop::layouts>