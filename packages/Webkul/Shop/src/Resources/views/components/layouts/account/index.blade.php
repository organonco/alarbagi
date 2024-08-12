<x-shop::layouts :has-header="true" :has-feature="false" :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        {{ $title ?? '' }}
    </x-slot>

    @php
        $pages = Webkul\CMS\Models\CmsPage::whereHas('translations')->get();
    @endphp

    {{-- Page Content --}}
    <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] mb-4">
        <x-shop::layouts.account.breadcrumb />

        <div class="flex gap-[40px] items-start mt-[30px] max-lg:gap-[20px] max-md:grid">
            <x-shop::layouts.account.navigation />

            <div class="flex-auto overflow-hidden mb-8">
                {{ $slot }}
            </div>

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
                <div
                    class="sn-heading-3 border-b-2 sn-border-secondary text-center pb-2 w-fit sn-color-secondary mb-2 max-lg:text-center max-lg:items-center">
                    تواصل معنا
                </div>
                <a href="mailto:admin@alarbaji.com" class="sn-heading-3 sn-color-primary max-lg:text-center">
                    admin@alarbaji.com
                </a>
                <a href="https://www.alarbagi.com" class="sn-heading-3 sn-color-primary text-right max-lg:text-center"
                    dir="ltr">
                    www.alarbagi.com
                </a>
                <a href="tel:+96332132132" class="sn-heading-3 sn-color-primary text-right max-lg:text-center mb-8"
                    dir="ltr">
                    +963321342142
                </a>

            </div>
        </div>
    </div>
</x-shop::layouts>
