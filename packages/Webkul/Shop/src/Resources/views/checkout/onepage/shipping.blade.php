{!! view_render_event('bagisto.shop.checkout.shipping.method.before') !!}

<v-shipping-method ref="vShippingMethod">
    {{-- Shipping Method Shimmer Effect --}}
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-method>

{!! view_render_event('bagisto.shop.checkout.shipping.method.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-shipping-method-template">
        <div class="mt-[30px]">
            <template v-if="! isShowShippingMethod && isShippingMethodLoading">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method/>
            </template>

            <template v-if="isShowShippingMethod">
                <x-shop::accordion>
                    <x-slot:header>
                        <div class="flex justify-between items-center">
                            <h2 class="sn-color-primary sn-heading-2">
                                @lang('shop::app.checkout.onepage.shipping.shipping-method')
                            </h2>
                        </div>
                    </x-slot:header>

                    <x-slot:content>
                        <div class="flex flex-wrap mt-[30px]">
                            <div
                                class="relative max-sm:max-w-full max-sm:flex-auto select-none max-lg:w-full"
                                v-for="shippingMethod in shippingMethods"
                            >
                                <div v-for="rate in shippingMethod.rates">
                                    <div v-if="rate.is_available && rate.is_visible" style="margin-left: 20px">
                                        <input type="radio" name="shipping_method" :id="rate.method" :value="rate.method" class="hidden peer" @change="store(rate.method)"/>
                                        <label class="icon-radio-unselect absolute top-[20px] text-[24px] sn-color-secondary peer-checked:icon-radio-select cursor-pointer" :for="rate.method" style="left: 40px"></label>
                                        <label class="block p-[20px] border border-[#E9E9E9] rounded-[12px] cursor-pointer" :for="rate.method">
											<div class="flex gap-4">
                                            	<span :class="'text-[60px] sn-color-primary ' + rate.method_icon"></span>
												<div>
													<p class="sn-heading-3 sn-color-primary"> @{{ rate.method_title }} </p>
													<p class="text-[12px] mt-[10px] font-medium"> @{{ rate.method_description }} </p>
												</div>
											</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div
                                    class="relative max-sm:max-w-full max-sm:flex-auto select-none max-lg:w-full"
                                    v-for="shippingMethod in shippingMethods"
                                >
                                <div v-for="rate in shippingMethod.rates">
                                    <div v-if="!rate.is_available && rate.is_visible" style="margin-left: 20px">
                                        <label class="icon-radio-unselect absolute top-[20px] text-[24px] sn-color-disabled peer-checked:icon-radio-select cursor-pointer" :for="rate.method" style="left: 40px"></label>
                                        <label class="block p-[20px] border border-[#E9E9E9] rounded-[12px] cursor-not-allowed" :for="rate.method">
											<div class="flex gap-4">
                                            	<span :class="'text-[60px] sn-color-disabled ' + rate.method_icon"></span>
												<div>
													<p class="sn-heading-3 sn-color-disabled"> @{{ rate.method_title }} </p>
													<p class="text-[12px] mt-[10px] font-medium sn-color-disabled"> @{{ rate.method_description }} </p>
												</div>
											</div>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </x-slot:content>
                </x-shop::accordion>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-method', {
            template: '#v-shipping-method-template',

            data() {
                return {
                    shippingMethods: [],

                    isShowShippingMethod: false,

                    isShippingMethodLoading: false,
                }
            },

            methods: {
                store(selectedShippingMethod) {
                    this.$parent.$refs.vCartSummary.canPlaceOrder = false;

                    this.$parent.$refs.vPaymentMethod.isShowPaymentMethod = false;

                    this.$parent.$refs.vPaymentMethod.isPaymentMethodLoading = true;

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {
                            shipping_method: selectedShippingMethod,
                        })
                        .then(response => {
                            this.$parent.getOrderSummary();

                            this.$parent.$refs.vPaymentMethod.payment_methods = response.data.payment_methods;

                            this.$parent.$refs.vPaymentMethod.isShowPaymentMethod = true;

                            this.$parent.$refs.vPaymentMethod.isPaymentMethodLoading = false;
                        })
                        .catch(error => {});
                },
            },
        });
    </script>
@endPushOnce
