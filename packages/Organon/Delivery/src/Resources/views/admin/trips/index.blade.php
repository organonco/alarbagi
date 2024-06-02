<x-admin::layouts>
    <x-slot:title>
        {{ __('Trips') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Trips') }}
        </p>

        <div class="flex gap-x-[10px] items-center">

            <a href="{{ route('admin.delivery.trips.create.pickup') }}">
                <div class="primary-button">
                    {{ __('Create Pickup Trip') }}
                </div>
            </a>

            <a href="{{ route('admin.delivery.trips.create.shipping') }}">
                <div class="primary-button">
                    {{ __('Create Shipping Trip') }}
                </div>
            </a>

        </div>
    </div>

    <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

        <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
            <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                <h2 class="text-gray-800 dark:text-white">
                    Pending Warehouses ({{ $pendingWarehouses->count() }})
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Warehouses with one or mroe packages ready for pickup
                </p>
                <div class="mt-[28px]">
                    @foreach ($pendingWarehouses as $warehouse)
                        <div class="flex content-between">
                            <div class="">
                                {{ $warehouse->name . '(' . $warehouse->pendingPackagesCount . ')' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Columns --}}
        <div class=" flex flex-col gap-[8px] w-[360px] max-w-full max-sm:w-full">
            {{-- Rows --}}
            <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                <h2 class="text-gray-800 dark:text-white">
                    Available Drivers ({{ $availableDrivers->count() }})
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Drivers without any ongoing or pending trips
                </p>
                <div class="mt-[28px]">
                    @foreach ($availableDrivers as $driver)
                        <div class="flex content-between">
                            <div class="">
                                {{ $driver->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap ">
        <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
            <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                <h2 class="text-gray-800 dark:text-white">
                    Pending Orders ({{ $shippableOrders->count() }})
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Orders ready for shipping
                </p>
                <div class="mt-[28px]">
                    @foreach ($shippableOrders as $order)
                        <div class="flex content-between">
                            <div class="">
                                {{ $order->name . '(' . 4 . ')' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-admin::layouts>
