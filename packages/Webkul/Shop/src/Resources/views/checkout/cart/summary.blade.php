<div class="w-[418px] max-w-full">
    <p class="sn-heading-2 sn-color-primary">
        @lang('shop::app.checkout.cart.summary.cart-summary')
    </p>

    <div class="grid gap-[15px] mt-[25px]">
        
        <div class="flex justify-between text-right">
            <p class="sn-heading-3 sn-font-regular">
                @lang('shop::app.checkout.cart.summary.preperation-time')
            </p>

            <p 
                class="sn-heading-3" 
                v-text="cart.preperation_time"
            >
            </p>
        </div>

        <div class="flex justify-between text-right">
            <p class="sn-heading-3 sn-font-regular">
                @lang('shop::app.checkout.cart.summary.grand-total')
            </p>

            <p 
                class="sn-heading-3" 
                v-text="cart.formatted_grand_total"
            >
            </p>
        </div>

        <a 
            href="{{ route('shop.checkout.onepage.index') }}" 
            class="block w-max place-self-end mt-[15px] text-center cursor-pointer sn-button-secondary"
        >
            @lang('shop::app.checkout.cart.summary.proceed-to-checkout')
        </a>
    </div>
</div>