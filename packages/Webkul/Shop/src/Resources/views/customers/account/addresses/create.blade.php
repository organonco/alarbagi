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
            <x-shop::form.control-group.control type="text" name="phone" :label="trans('shop::app.checkout.onepage.addresses.shipping.phone')"
                rules="required|phone" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.phone')">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error control-name="phone">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.checkout.onepage.addresses.shipping.area_id')
            </x-shop::form.control-group.label>
            <x-shop::form.control-group.control type="select" name="area_id" class="py-2 mb-2"
                :label="trans('shop::app.checkout.onepage.addresses.shipping.area_id')" :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.area_id')">
                @foreach ($areas as $area)
                    <option value="{{$area->id}}">{{$area->name . ($area->is_shippable ? '' : ' - التوصيل غير متاح') }}</option>
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
                :placeholder="trans('shop::app.checkout.onepage.addresses.shipping.address_details')">
            </x-shop::form.control-group.control>
            <x-shop::form.control-group.error class="mb-2" control-name="address_details">
            </x-shop::form.control-group.error>
        </x-shop::form.control-group>

        <button type="submit" class="sn-button-primary">
            @lang('shop::app.customers.account.addresses.save')
        </button>

        {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.after') !!}

    </x-shop::form>

    {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}

</x-shop::layouts.account>
