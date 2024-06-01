<x-admin::layouts>
    <x-slot:title>
        {{ __('Trips') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('New Trip') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.trips.create') }}">
                <div class="primary-button">
                    {{ __('Save') }}
                </div>
            </a>
        </div>
    </div>

</x-admin::layouts>
