<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.edit')
        @lang('shop::app.customers.account.addresses.title')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="addresses.edit" :entity="$address"></x-shop::breadcrumbs>
    @endSection

    <h2 class="text-[26px] font-medium">
        @lang('shop::app.customers.account.addresses.edit')
        @lang('shop::app.customers.account.addresses.title')
    </h2>

    {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

    {{-- Edit Address Form --}}
    <x-shop::form method="PUT" :action="route('shop.customers.account.addresses.update', $address->id)" class="rounded mt-[30px]">

        <x-shop::form.control-group>
            <x-shop::form.control-group.label class="required">
                @lang('shop::app.checkout.onepage.addresses.shipping.name')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="name" :label="trans('shop::app.checkout.onepage.addresses.shipping.name')" rules="required"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.name')" value="{{$address->name}}">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="name">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label class="required">
                @lang('shop::app.checkout.onepage.addresses.shipping.phone')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="phone" :label="trans('shop::app.checkout.onepage.addresses.shipping.phone')" rules="required|phone"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.phone')" value="{{$address->phone}}">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="phone">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.location')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="text" name="pac-input" placeholder="بحث" class="mb-2">
            </x-shop::form.control-group.control>
            <div id="map"></div>
            <input type="hidden" name="lng" id="lngInput" value="{{$address->lng}}" />
            <input type="hidden" name="lat" id="latInput" value="{{$address->lat}}" />
        </x-shop::form.control-group>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.area_id')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="select" name="area_id" class="py-2 mb-2" :label="trans('shop::app.checkout.onepage.addresses.shipping.area_id')"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.area_id')" value="{{$address->area_id}}">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">
                        {{ $area->name . ($area->is_shippable ? '' : ' - التوصيل غير متاح') }}</option>
                @endforeach
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="area_id">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group class="!mb-4">
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.address_details')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="textarea" name="address_details" :label="trans('shop::app.checkout.onepage.addresses.shipping.address_details')"
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.address_details')" value="{{$address->address_details}}">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error class="mb-2" control-name="address_details">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <button type="submit" class="sn-button-primary">
            @lang('shop::app.customers.account.addresses.save')
        </button>

        {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.after', [
            'address' => $address,
        ]) !!}

    </x-shop::form>

    {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}

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
                let initialLat = Number(document.getElementById("latInput").value)
                let initialLng = Number(document.getElementById("lngInput").value)
                window.loader.load().then((google) => {
                    const map = new google.maps.Map(document.getElementById('map'), {
                        center: {
                            lat: initialLat == 0 ? 33.51370659236307 : initialLat,
                            lng: initialLng == 0 ? 36.27639307403564 : initialLng,
                        },
                        zoom: 15,
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
