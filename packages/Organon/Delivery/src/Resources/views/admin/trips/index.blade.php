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
                    Seller warehouses with one or mroe packages ready for pickup
                </p>
                <div class="mt-[28px]">
                    @foreach ($pendingWarehouses as $warehouse)
                        <div class="flex content-between">
                            <div class="">
                                {{ $warehouse->name . ' (' . $warehouse->pendingPackagesCount . ' Packages )' }}
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
                    Orders ready to be shipped to clients
                </p>
                <div class="mt-[28px]">
                    @foreach ($shippableOrders as $group)
                        <div class="flex content-between">
                            <div class="">
                                {{ $group[0]->name . ' (' . $group->count() . ' Orders)' }}
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
                <div class="flex gap-[15px] mb-[15px] pt-[8px] border-b-[2px] max-sm:hidden dark:border-gray-800">
                    <a href="?status=in-progress">
                        <div
                            class="{{ $tripsStatus == 'in-progress' ? 'mb-[-1px] border-blue-600 border-b-[2px] transition' : '' }} pb-[14px] px-[10px] text-[16px] font-medium text-gray-600 dark:text-gray-300 cursor-pointer">
                            In Progress
                        </div>
                    </a>

                    <a href="?status=pending">
                        <div
                            class="{{ $tripsStatus == 'pending' ? 'mb-[-1px] border-blue-600 border-b-[2px] transition' : '' }} pb-[14px] px-[10px] text-[16px] font-medium text-gray-600 dark:text-gray-300 cursor-pointer">
                            Pending
                        </div>
                    </a>

                    <a href="?status=done">
                        <div
                            class="{{ $tripsStatus == 'done' ? 'mb-[-1px] border-blue-600 border-b-[2px] transition' : '' }} pb-[14px] px-[10px] text-[16px] font-medium text-gray-600 dark:text-gray-300 cursor-pointer">
                            Done
                        </div>
                    </a>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                </p>
                <div class="flex flex-row flex-wrap gap-2">
                    @foreach ($trips as $trip)
                        <div style="border: gray 1px solid; padding: 10px; border-radius: 10px; width: 400px">
                            <h2 style="font-weight: 900">
                                {{ $trip->getType() }}
                            </h2>
                            <div>
                                {{ $trip->driver->name }}
                            </div>
                            <hr style="margin: 10px 0" />
                            @if ($trip->isPickup())
                                <div class="flex flex-row gap-2">
                                    @foreach ($trip->parts as $part)
                                        @if ($part->direction == '0')
                                            <div
                                                style="background-color: antiquewhite; border-radius: 10px; padding: 2px 8px 2px 8px ">
                                                {{ $part->part->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr style="margin: 10px 0" />
                                <div class="flex flex-row gap-2">
                                    @foreach ($trip->parts as $part)
                                        @if ($part->direction == '1')
                                            <div
                                                style="background-color: antiquewhite; border-radius: 10px; padding: 2px 8px 2px 8px ">
                                                {{ $part->part->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-row gap-2">
                                    @foreach ($trip->parts as $part)
                                        <div
                                            style="background-color: antiquewhite; border-radius: 10px; padding: 2px 8px 2px 8px ">
                                            {{ $part->part->name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-admin::layouts>
