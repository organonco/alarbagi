{!! view_render_event('bagisto.shop.checkout.cart.summary.before') !!}

<v-cart-summary ref="vCartSummary" :cart="cart" :is-cart-loading="isCartLoading">
</v-cart-summary>

{!! view_render_event('bagisto.shop.checkout.cart.summary.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-cart-summary-template">
		<template v-if="isCartLoading">
			<!-- onepage Summary Shimmer Effect -->
			<x-shop::shimmer.checkout.onepage.cart-summary/>
		</template>

		<template v-else>
			<div class="sticky top-[30px] h-max w-[442px] max-w-full pl-[30px] max-lg:w-auto max-lg:max-w-[442px] max-lg:pl-0 ">
				<h2 class="sn-heading-2 sn-color-primary">
					@lang('shop::app.checkout.onepage.summary.cart-summary')
				</h2>
				
				<div class="grid mt-[40px] border-b-[1px] border-[#E9E9E9] max-sm:mt-[20px]">
					<div 
						class="flex gap-x-[15px] pb-[20px]"
						v-for="item in cart.items"
					>
						<img
							class="max-w-[90px] max-h-[90px] w-[90px] h-[90px] rounded-md"
							:src="item.base_image.small_image_url"
							:alt="item.name"
							width="110"
							height="110"
						/>

						<div class="grid place-content-center">
							<p 
								class="sn-heading-3 sn-color-primary" 
								v-text="item.name"
							>
							</p>

							<p class="mt-[10px] text-[18px] font-medium max-sm:text-[14px] max-sm:font-normal">
								@{{ item.formatted_price }} (@{{ item.quantity }} قطعة)
							</p>
						</div>
					</div>
				</div>

				<div class="grid gap-[15px] mt-[25px] mb-[30px]">
					<div class="flex text-right justify-between">
						<p class="text-[16px] max-sm:text-[14px] max-sm:font-normal">
							@lang('shop::app.checkout.cart.summary.preperation-time')
						</p>

						<p 
							class="sn-heading-3"
							v-text="cart.preperation_time"
						>
						</p>
					</div>

					<div class="flex text-right justify-between">
						<p class="text-[16px] max-sm:text-[14px] max-sm:font-normal">
							@lang('shop::app.checkout.onepage.summary.sub-total')
						</p>

						<p 
							class="sn-heading-3"
							v-text="cart.base_sub_total"
						>
						</p>
					</div>

					<div 
						class="flex text-right justify-between"
						v-if="cart.raw_selected_shipping_rate > 0"
					>
						<p class="text-[16px]">
							@lang('shop::app.checkout.onepage.summary.delivery-charges')
						</p>

						<p 
							class="sn-heading-3"
							v-text="cart.selected_shipping_rate"
						>
						</p>
					</div>

					<div class="flex text-right justify-between">
						<p class="text-[18px] font-semibold">
							@lang('shop::app.checkout.onepage.summary.grand-total')
						</p>

						<p 
							class="sn-heading-3"
							v-text="cart.base_grand_total"
						>
						</p>
					</div>
				</div>

				<template v-if="canPlaceOrder">
					<div v-if="selectedPaymentMethod?.method == 'paypal_smart_button'">
						<v-paypal-smart-button></v-paypal-smart-button>
					</div>

					<div
						class="flex flex-col justify-start"
						v-else
					>
					
						<div class="">
							<textarea 
								placeholder="أضف ملاحظة مع الطلب!" 
								v-model="note"
								class="w-full pt-4 pb-4 px-3 shadow border rounded text-[14px] text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400"
							/>
						</div>

						<button
							v-if="! isLoading"
							class="block sn-button-primary"
							@click="placeOrder"
						>
							@lang('shop::app.checkout.onepage.summary.place-order')    
						</button>

						<button
							v-else
							class="flex gap-[10px] items-center sn-button-primary w-full justify-center"
						>
							<!-- Spinner -->
							<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
								<circle
									class="opacity-25"
									cx="12"
									cy="12"
									r="10"
									stroke="currentColor"
									stroke-width="4"
								>
								</circle>

								<path
									class="opacity-75"
									fill="currentColor"
									d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
								>
								</path>
							</svg>

							@lang('shop::app.checkout.onepage.summary.processing')
						</button>
					</div>
				</template>
			</div>
		</template>
	</script>

    <script type="module">
        app.component('v-cart-summary', {
            template: '#v-cart-summary-template',

            props: ['cart', 'isCartLoading'],

            data() {
                return {
                    canPlaceOrder: false,

                    selectedPaymentMethod: null,

                    isLoading: false,

                    note: "",
                }
            },

            methods: {
                placeOrder() {
                    this.isLoading = true;

                    this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}', {
                            note: this.note
                        })
                        .then(response => {
                            if (response.data.data.redirect) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                            }
                        })
                        .catch(error => console.log(error));
                },
            },
        });
    </script>
@endPushOnce
