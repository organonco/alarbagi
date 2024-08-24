@php
	$pages = Webkul\CMS\Models\CmsPage::whereHas('translations')->get();
@endphp

<div
        class="sn-background-primary px-28 max-lg:px-10 py-16 grid-cols-5 grid max-lg:flex max-lg:flex-col max-lg:gap-4 max-lg:pt-20 max-lg:pb-40">
        <div class="col-span-3 max-lg:pr-0 flex pr-10">
            <div class="flex flex-col items-center">
                <img src="{{ asset('assets/images/logo-orange.png') }}" class="w-[24rem]">
                <div class="text-[28px] text-white font-bold mt-8 text-center max-lg:!text-2xl">
                    المحل محلك وانت بمحلك
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2 max-lg:items-center max-lg:hidden">
            <div
                class="sn-heading-3 border-b-2 sn-border-secondary text-center pb-2 w-fit sn-color-secondary mb-2 max-lg:text-center">
                {{-- الصفحات الثانوية --}}
            </div>
            @foreach ($pages as $page)
                <a href="{{ route('shop.cms.page', $page->translations[0]->url_key) }}"
                    class="sn-heading-3 sn-color-white max-lg:text-center">
                    {{ $page->translations[0]->page_title }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-col gap-2 max-lg:items-center max-lg:hidden">
            <div
                class="sn-heading-3 border-b-2 sn-border-secondary text-center pb-2 w-fit sn-color-secondary mb-2 max-lg:text-center max-lg:items-center">
                تواصل معنا
            </div>
            <a href="mailto:admin@alarbaji.com" class="sn-heading-3 sn-color-white max-lg:text-center">
                admin@alarbaji.com
            </a>
            <a href="https://www.alarbagi.com" class="sn-heading-3 sn-color-white text-right max-lg:text-center"
                dir="ltr" target="_blank">
                www.alarbagi.com
            </a>
            <a href="tel:+96332132132" class="sn-heading-3 sn-color-white text-right max-lg:text-center" dir="ltr">
                +963321342142
            </a>

        </div>
    </div>