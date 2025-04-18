{!! view_render_event('bagisto.shop.checkout.addresses.before') !!}

<v-checkout-addresses 
    ref="vCheckoutAddress"
    :have-stockable-items="cart.haveStockableItems"
>
</v-checkout-addresses>

{!! view_render_event('bagisto.shop.checkout.addresses.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-checkout-addresses-template">
        <template v-if="isAddressLoading">
            <!-- Onepage Shimmer Effect -->
            <x-shop::shimmer.checkout.onepage.address/>
        </template>
        
        <template v-else>
            <div class="mt-[30px]">
                @include('shop::checkout.onepage.addresses.shipping')
            </div>
        </template>
    </script>

    <script type="module">
         app.component('v-checkout-addresses', {
            template: '#v-checkout-addresses-template',

            props: ['haveStockableItems'],

            data() {
                return  {
                    forms: {
                        shipping: {
                            address: {
                                address1: [''],
                                isSaved: false,
                            },
                            isNew: false,
                        },
                    },

                    addresses: [],

                    areas: [],

                    isAddressLoading: true,

                    isCustomer: "{{ auth()->guard('customer')->check() }}",

                    isTempAddress: false,
                }
            }, 
            
            created() {
                this.getCustomerAddresses();
                this.getAreas();
            },

            methods: {
                resetShippingAddressForm() {
                    this.forms.shipping.address = {
                        address1: [''],

                        isSaved: false,
                    };
                },

                resetPaymentAndShippingMethod() {
                    this.$parent.$refs.vShippingMethod.isShowShippingMethod = false;

                    this.$parent.$refs.vPaymentMethod.isShowPaymentMethod = false;
                },

                getCustomerAddresses() {
                    if (this.isCustomer) {
                        this.$axios.get("{{ route('api.shop.customers.account.addresses.index') }}")
                            .then(response => {
                                this.addresses = response.data.data.map((address, index) => {
                                    let isDefault = address.default_address ? address.default_address : index === 0;

                                    if (isDefault) {
                                        this.forms.shipping.address.address_id = address.id;
                                    }

                                    return {
                                        ...address,
                                        isSaved: true,
                                        isDefault: isDefault
                                    };
                                });

                                this.isAddressLoading = false;
                            })
                            .catch((error) => {});
                    } else {
                        this.isAddressLoading = false;
                    }
                },

                getAreas() {
                    this.$axios.get("{{ route('api.shop.customers.account.addresses.areas.index') }}")
                        .then(response => {
                            this.areas = response.data;
                        })
                        .catch(function (error) {});
                },

                showNewShippingAddressForm() {
                    this.resetShippingAddressForm();

                    this.forms.shipping.isNew = true;

                    this.resetPaymentAndShippingMethod();
                },

                handleShippingAddressForm() {
                    this.forms.shipping.address.lat = document.getElementById("latInput").value
                    this.forms.shipping.address.lng = document.getElementById("lngInput").value
                    
                    if (this.forms.shipping.isNew && ! this.forms.shipping.address.isSaved) {
                        this.forms.shipping.isNew = false;
                        this.isTempAddress = true;
                        this.areas.forEach(element => {
                            if(element['id'] == this.forms.shipping.address.area_id)
                                this.forms.shipping.address.area = element['name']
                        });
                        this.addresses.push({
                            ...this.forms.shipping.address,
                            isSaved: false,
                        });
                    } else if (this.forms.shipping.isNew && this.forms.shipping.address.isSaved) {
                        this.$axios.post('{{ route("api.shop.customers.account.addresses.store") }}', this.forms.shipping.address)
                            .then(response => {
                                this.forms.shipping.isNew = false;

                                this.resetShippingAddressForm();
                                
                                this.getCustomerAddresses();
                            })
                            .catch(error => {                 
                                console.log(error);
                            });
                    }
                },

                store() {
                    if (this.haveStockableItems) {
                        this.$parent.$refs.vShippingMethod.isShowShippingMethod = false;
                        
                        this.$parent.$refs.vShippingMethod.isShippingMethodLoading = true;
                    } else {
                        this.$parent.$refs.vPaymentMethod.isShowPaymentMethod = false;
    
                        this.$parent.$refs.vPaymentMethod.isPaymentMethodLoading = true;
                    }

                    this.$axios.post('{{ route("shop.checkout.onepage.addresses.store") }}', {
                            shipping: {
                                ...this.forms.shipping.address,
                            },
                        })
                        .then(response => {
                            if (response.data.data.payment_methods) {
                                this.$parent.$refs.vPaymentMethod.payment_methods = response.data.data.payment_methods;
                                
                                this.$parent.$refs.vPaymentMethod.isShowPaymentMethod = true;
    
                                this.$parent.$refs.vPaymentMethod.isPaymentMethodLoading = false;
                            } else {
                                this.$parent.$refs.vShippingMethod.shippingMethods = response.data.data.shippingMethods;

                                this.$parent.$refs.vShippingMethod.isShowShippingMethod = true;

                                this.$parent.$refs.vShippingMethod.isShippingMethodLoading = false;
                            }
                            
                            this.$parent.getOrderSummary();
                            
                        })
                        .catch(error => {                 
                            console.log(error);
                        });
                },

                haveStates(addressType) {
                    if (
                        this.states[this.forms[addressType].address.country]
                        && this.states[this.forms[addressType].address.country].length
                    ) {
                        return true;
                    }

                    return false;
                },
            },
        });
    </script>
@endPushOnce