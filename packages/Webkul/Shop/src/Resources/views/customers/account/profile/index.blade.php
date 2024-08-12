<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.profile.title')
    </x-slot>

    @php
        $pages = Webkul\CMS\Models\CmsPage::whereHas('translations')->get();
    @endphp

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="profile"></x-shop::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <h2 class="text-[26px] font-medium">
            @lang('shop::app.customers.account.profile.title')
        </h2>

        <a href="{{ route('shop.customers.account.profile.edit') }}" class="sn-button-primary">
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

        <form method="POST" action={{ route('shop.customer.session.destroy') }}>
            @csrf
            @method('delete')
            <button class="sn-button-primary-alt text-center" type="submit">
                @lang('shop::app.customers.account.profile.logout')
            </button>
        </form>
        <div class="flex-col gap-2 max-lg:items-center hidden max-lg:flex">
            <div
                class="sn-heading-3 border-b-2 sn-border-secondary text-center pb-2 w-fit sn-color-secondary mb-2 max-lg:text-center">
                {{-- الصفحات الثانوية --}}
            </div>
            @foreach ($pages as $page)
                <a href="{{ route('shop.cms.page', $page->translations[0]->url_key) }}"
                    class="sn-heading-3 sn-color-primary max-lg:text-center">
                    {{ $page->translations[0]->page_title }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-col gap-2 max-lg:items-center hidden max-lg:flex">

            <a href="tel:+963943175715" class="sn-heading-3 sn-color-primary text-right max-lg:text-center mb-8"
                dir="ltr">
                +963943175715
            </a>

            <div
                class="sn-heading-3 border-b-2 sn-border-secondary text-center pb-2 w-fit sn-color-secondary mb-2 max-lg:text-center max-lg:items-center">
                تواصل معنا
            </div>
            <a href="mailto:support@alarbagi.com" class="sn-heading-3 sn-color-primary max-lg:text-center">
                support@alarbagi.com
            </a>
            <a href="https://www.alarbagi.com" class="sn-heading-3 sn-color-primary text-right max-lg:text-center"
                dir="ltr">
                www.alarbagi.com
            </a>


        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}

    </div>
</x-shop::layouts.account>
