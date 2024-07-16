<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="false"
    >
    {{-- Page Title --}}
    <x-slot:title>
        {{ $title ?? '' }}
    </x-slot>

    {{-- Page Content --}}
    <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] mb-4">
        <x-shop::layouts.account.breadcrumb />

        <div class="flex gap-[40px] items-start mt-[30px] max-lg:gap-[20px] max-md:grid">
            <x-shop::layouts.account.navigation />

            <div class="flex-auto overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-shop::layouts>
