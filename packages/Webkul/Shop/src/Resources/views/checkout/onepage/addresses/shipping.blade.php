<div>
    <div class="mt-[30px]" v-if="! forms.shipping.isNew">

        {!! view_render_event('bagisto.shop.checkout.onepage.shipping.accordion.before') !!}

        <x-shop::accordion class="!border-b-[0px]">
            <x-slot:header>
                <div class="flex justify-between items-center">
                    <h2 class="text-[26px] font-medium max-sm:text-[20px]">
                        @lang('shop::app.checkout.onepage.addresses.shipping.shipping-address')
                    </h2>
                </div>
            </x-slot:header>

            <x-slot:content>
                <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
                    <form @submit="handleSubmit($event, store)">
                        <div
                            class="grid grid-cols-2 mt-[30px] gap-[20px] max-1060:grid-cols-[1fr] max-lg:grid-cols-2 max-sm:grid-cols-1 max-sm:mt-[15px]">
                            <div class="relative max-w-[414px] p-[0px] border border-[#e5e5e5] rounded-[12px] max-sm:flex-wrap select-none cursor-pointer"
                                v-for="(address, index) in addresses">
                                <v-field type="radio" name="shipping[address_id]" :value="address.id"
                                    :id="'shipping_address_id_' + address.id" class="hidden peer"
                                    :rules="{ required: !isTempAddress }" label="@lang('shop::app.checkout.onepage.addresses.shipping.shipping-address')"
                                    v-model="forms.shipping.address.address_id" :checked="address.isDefault"
                                    @change="resetPaymentAndShippingMethod" />

                                <label
                                    class="icon-radio-unselect absolute ltr:right-[20px] rtl:left-[20px] top-[20px] text-[24px] sn-color-secondary peer-checked:icon-radio-select cursor-pointer"
                                    :for="'shipping_address_id_' + address.id">
                                </label>

                                <label :for="'shipping_address_id_' + address.id"
                                    class="block p-[20px] rounded-[12px] cursor-pointer">
                                    <div class="flex justify-between items-center">
                                        <p class="text-[16px] font-medium">
                                            @{{ address.name }} - @{{ address.phone }}
                                        </p>
                                    </div>
                                    <p class="mt-[16px] text-[#6E6E6E] text-[14px]">
                                        <template v-if="address.area && address.address_details">
                                            @{{ address.area }} - @{{ address.address_details }}
                                        </template>
                                        <template v-else>
                                            @{{ address.area }} @{{ address.address_details }}
                                        </template>
                                    </p>
                                </label>
                            </div>

                            <div class="flex justify-center items-center max-w-[414px] p-[20px] border border-[#e5e5e5] rounded-[12px] max-sm:flex-wrap"
                                @click="showNewShippingAddressForm">
                                <div class="flex gap-x-[10px] items-center cursor-pointer">
                                    <span
                                        class="icon-plus p-[10px] text-[30px]  border border-black rounded-full"></span>

                                    <p class="text-[16px]">@lang('shop::app.checkout.onepage.addresses.shipping.add-new-address')</p>
                                </div>
                            </div>
                        </div>

                        <v-error-message class="text-red-500 text-xs italic" name="shipping[address_id]">
                        </v-error-message>


                        <template v-if="meta.valid">
                            <div v-if="! forms.shipping.isNew">
                                <div class="flex justify-end mt-4 mb-4">
                                    <button class="block w-max sn-button-primary-alt" @click="store">
                                        @lang('shop::app.checkout.onepage.addresses.shipping.confirm')
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <div v-if="! forms.shipping.isNew">
                                <div class="flex justify-end mt-4 mb-4">
                                    <button type="submit" class="block w-max sn-button-primary-alt">
                                        @lang('shop::app.checkout.onepage.addresses.shipping.confirm')
                                    </button>
                                </div>
                            </div>
                        </template>
                    </form>
                </x-shop::form>
            </x-slot:content>
        </x-shop::accordion>

        {!! view_render_event('bagisto.shop.checkout.onepage.shipping.accordion.after') !!}

    </div>

    <div class="mt-[30px]" v-else>
        <x-shop::accordion>
            <x-slot:header>
                <div class="flex justify-between items-center">
                    <h2 class="text-[26px] font-medium max-sm:text-[20px]">
                        @lang('shop::app.checkout.onepage.addresses.shipping.shipping-address')
                    </h2>
                </div>
            </x-slot:header>

            <x-slot:content>

                {!! view_render_event('bagisto.shop.checkout.onepage.shipping_address.before') !!}

                {{-- Shipping address form --}}
                <x-shop::form v-slot="{ meta, errors, handleSubmit }" as="div">
                    <form @submit="handleSubmit($event, handleShippingAddressForm)">
                        <div>
                            <a class="flex justify-end" href="javascript:void(0)" v-if="addresses.length > 0"
                                @click="forms.shipping.isNew = ! forms.shipping.isNew">
                                <span class="icon-arrow-left text-[24px]"></span>

                                <span>@lang('shop::app.checkout.onepage.addresses.shipping.back')</span>
                            </a>
                        </div>

                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.checkout.onepage.addresses.shipping.name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="text" name="shipping[name]" :label="trans('shop::app.checkout.onepage.addresses.shipping.name')"
                                rules="required" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.name')" v-model="forms.shipping.address.name">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="shipping[name]">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.checkout.onepage.addresses.shipping.phone')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="text" name="shipping[phone]" :label="trans('shop::app.checkout.onepage.addresses.shipping.phone')"
                                rules="required|phone" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.phone')" v-model="forms.shipping.address.phone">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="shipping[phone]">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>


                        <h3 class="text-[26px] font-medium !mt-12">
                            @lang('shop::app.customers.account.addresses.address-details')
                        </h3>


                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label>
                                @lang('shop::app.checkout.onepage.addresses.shipping.area_id')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="select" name="shipping[area_id]"
                                class="py-2 mb-2" :label="trans('shop::app.checkout.onepage.addresses.shipping.area_id')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.area_id')"
                                v-model="forms.shipping.address.area_id">
                                <option v-for="area in areas" :value="area.id"
                                    v-text="area.name + (area.is_shippable ? '' : ' - التوصيل غير متاح') ">
                                </option>
                            </x-shop::form.control-group.control>
                            <x-shop::form.control-group.error control-name="shipping[area_id]">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <div class="flex gap-2 w-full">

                            <x-shop::form.control-group class="w-full">
                                <x-shop::form.control-group.label>
                                    @lang('shop::app.checkout.onepage.addresses.shipping.street')
                                </x-shop::form.control-group.label>
                                <x-shop::form.control-group.control class="w-full" type="text" name="street"
                                    :label="trans('shop::app.checkout.onepage.addresses.shipping.street')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.street')" v-model="forms.shipping.address.street">
                                </x-shop::form.control-group.control>
                                <x-shop::form.control-group.error class="mb-2" control-name="street">
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>


                            <x-shop::form.control-group class="w-full">
                                <x-shop::form.control-group.label>
                                    @lang('shop::app.checkout.onepage.addresses.shipping.building')
                                </x-shop::form.control-group.label>
                                <x-shop::form.control-group.control class="w-full" type="text" name="building"
                                    :label="trans('shop::app.checkout.onepage.addresses.shipping.building')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.building')" v-model="forms.shipping.address.building">
                                </x-shop::form.control-group.control>
                                <x-shop::form.control-group.error class="mb-2" control-name="building">
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>

                            <x-shop::form.control-group class="w-full">
                                <x-shop::form.control-group.label>
                                    @lang('shop::app.checkout.onepage.addresses.shipping.floor')
                                </x-shop::form.control-group.label>
                                <x-shop::form.control-group.control class="w-full" type="text" name="floor"
                                    :label="trans('shop::app.checkout.onepage.addresses.shipping.floor')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.floor')" v-model="forms.shipping.address.floor">
                                </x-shop::form.control-group.control>
                                <x-shop::form.control-group.error class="mb-2" control-name="floor">
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>
                        </div>

                        <x-shop::form.control-group class="!mb-4">
                            <x-shop::form.control-group.label>
                                @lang('shop::app.checkout.onepage.addresses.shipping.address_details')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="textarea" name="shipping[address_details]"
                                :label="trans('shop::app.checkout.onepage.addresses.shipping.address_details')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.address_details')" v-model="forms.shipping.address.address_details">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error class="mb-2" control-name="shipping[address_details]">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>


                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label>
                                @lang('shop::app.checkout.onepage.addresses.shipping.location')
                            </x-shop::form.control-group.label>
                            <x-shop::form.control-group.control type="text" name="pac-input" placeholder="بحث"
                                class="mb-2">
                            </x-shop::form.control-group.control>
                            <div id="map"></div>
                            <input type="hidden" name="shipping[lng]" id="lngInput" />
                            <input type="hidden" name="shipping[lat]" id="latInput" />
                        </x-shop::form.control-group>


                        <div class="mt-[30px] pb-[15px]">
                            <div class="grid gap-[10px]">
                                @auth('customer')
                                    <div class="select-none flex gap-x-[15px]">
                                        <input type="checkbox" name="shipping[is_save_as_address]"
                                            id="shipping[is_save_as_address]" class="hidden peer"
                                            v-model="forms.shipping.address.isSaved">

                                        <label
                                            class="icon-uncheck text-[24px] text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                                            for="shipping[is_save_as_address]">
                                        </label>

                                        <label for="shipping[is_save_as_address]">
                                            @lang('shop::app.checkout.onepage.addresses.shipping.save-address')
                                        </label>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <div class="flex justify-end mt-4 mb-4">
                            <button type="submit" class="block w-max sn-button-primary-alt">
                                @lang('shop::app.checkout.onepage.addresses.shipping.confirm')
                            </button>
                        </div>
                    </form>

                    {!! view_render_event('bagisto.shop.checkout.onepage.shipping_address.control.after') !!}

                </x-shop::form>

                {!! view_render_event('bagisto.shop.checkout.onepage.shipping_address.after') !!}

            </x-slot:content>
        </x-shop::accordion>
    </div>
</div>

@pushOnce('scripts')
    <script>
        function waitForElement(selector, callback) {
            const interval = setInterval(() => {
                const element = document.querySelector(selector);
                if (element) {
                    clearInterval(interval);
                    callback(element);
                }
            }, 100);
        }

        waitForElement('#map', (element) => {
            window.loader.load().then((google) => {
                const map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: 33.51370659236307,
                        lng: 36.27639307403564
                    },
                    zoom: 12,
                });
                google.maps.event.addListener(map, 'dragend', function() {
                    const center = map.getCenter();

                    document.getElementById("latInput").value = center.lat()
                    document.getElementById("lngInput").value = center.lng()
                });

                const input = document.getElementById('pac-input');
                const autocomplete = new google.maps.places.Autocomplete(input);

                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    const location = place.geometry.location;
                    map.setCenter(location);
                    marker.setPosition(map.getCenter());
                });

                const marker = new google.maps.Marker({
                    center: {
                        lat: 33.5102,
                        lng: 36.2815
                    },
                    map: map,
                    draggable: false
                });

                marker.setPosition(map.getCenter());

                google.maps.event.addListener(map, 'drag', () => {
                    marker.setPosition(map.getCenter());
                });

                google.maps.event.addListener(map, 'zoom_changed', () => {
                    marker.setPosition(map.getCenter());
                });
            })
        });
    </script>
@endpushOnce
