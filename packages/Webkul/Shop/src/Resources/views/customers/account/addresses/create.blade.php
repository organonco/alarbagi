<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.add-address')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="addresses.create"></x-shop::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <div class="">
            <h2 class="text-[26px] font-medium">
                @lang('shop::app.customers.account.addresses.add-address')
            </h2>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.addresses.create.before') !!}

    {{-- Create Address Form --}}
    <x-shop::form :action="route('shop.customers.account.addresses.store')" class="rounded mt-[30px]">

        <x-shop::form.control-group>
            <x-shop::form.control-group.label class="required">
                @lang('shop::app.checkout.onepage.addresses.shipping.name')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="name" :label="trans('shop::app.checkout.onepage.addresses.shipping.name')" rules="required"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.name')">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="name">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label class="required">
                @lang('shop::app.checkout.onepage.addresses.shipping.phone')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="phone" :label="trans('shop::app.checkout.onepage.addresses.shipping.phone')" rules="required|phone"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.phone')">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="phone">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <h3 class="text-[26px] font-medium !mt-12">
            @lang('shop::app.customers.account.addresses.address-details')
        </h3>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.area_id')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="select" name="area_id" class="py-2 mb-2" :label="trans('shop::app.checkout.onepage.addresses.shipping.area_id')"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.area_id')">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">
                        {{ $area->name . ($area->is_shippable ? '' : ' - التوصيل غير متاح') }}</option>
                @endforeach
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="area_id">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <div class="flex gap-2 w-full">

            <x-shop::form.control-group class="w-full">
                <x-shop::form.control-group.label>
                    @lang('shop::app.checkout.onepage.addresses.shipping.street')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control class="w-full" type="text" name="street" :label="trans('shop::app.checkout.onepage.addresses.shipping.street')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.street')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error class="mb-2" control-name="street">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="w-full">
                <x-shop::form.control-group.label>
                    @lang('shop::app.checkout.onepage.addresses.shipping.building')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control class="w-full" type="text" name="building" :label="trans('shop::app.checkout.onepage.addresses.shipping.building')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.building')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error class="mb-2" control-name="building">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="w-full">
                <x-shop::form.control-group.label>
                    @lang('shop::app.checkout.onepage.addresses.shipping.floor')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control class="w-full" type="text" name="floor" :label="trans('shop::app.checkout.onepage.addresses.shipping.floor')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.floor')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error class="mb-2" control-name="floor">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>
        </div>


        <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.address_details')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="textarea" name="address_details" :label="trans('shop::app.checkout.onepage.addresses.shipping.address_details')"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.address_details')">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error class="mb-2" control-name="address_details">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group class="!mb-4">
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.location')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="pac-input" placeholder="بحث" class="mb-2">
            </x-shop::form.control-group.control>
            <div id="map"></div>
            <input type="hidden" name="lng" id="lngInput" value="33.51370659236307"/>
            <input type="hidden" name="lat" id="latInput" value="36.27639307403564"/>
        </x-shop::form.control-group>


        <button type="submit" class="sn-button-primary">
            @lang('shop::app.customers.account.addresses.save')
        </button>

        {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.after') !!}

    </x-shop::form>

    {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}

    @push('styles')
        <style>
            #map {
                height: 500px;
            }
        </style>
    @endpush

    @pushOnce('scripts')
        <script>
            window.addEventListener("load", function(event) {
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
</x-shop::layouts.account>
