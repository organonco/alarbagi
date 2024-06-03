<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.profile.title')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="profile"></x-shop::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <h2 class="text-[26px] font-medium">
            @lang('shop::app.customers.account.profile.title')
        </h2>

        <a href="{{ route('shop.customers.account.profile.edit') }}" class="sn-button-secondary">
            @lang('shop::app.customers.account.profile.edit')
        </a>
    </div>

    {{-- Profile Information --}}
    <div class="grid grid-cols-1 gap-y-[25px] mt-[30px]">
        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('shop::app.customers.account.profile.first-name')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->first_name }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('shop::app.customers.account.profile.last-name')
            </p>

            <p class="text-[14px] font-medium text-[#6E6E6E]">
                {{ $customer->last_name }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('shop::app.customers.account.profile.gender')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->gender ?? '-' }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('shop::app.customers.account.profile.dob')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->date_of_birth ?? '-' }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('shop::app.customers.account.profile.email')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->email }}
            </p>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.before') !!}

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}

    </div>
</x-shop::layouts.account>
