<x-delivery::driver-layout>

    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Trips
            </div>
        </div>
        <hr />
        <div class="description">
            Trips assigned to you by admins
        </div>
        <div class="content">
            <div class="flex flex-row flex-wrap justify-around mx-1 my-2 nav-tabs">
                <a class="{{ $tripsStatus == 'pending' ? 'selected' : '' }}" href="?status=pending"> Pending </a>
                <a class="{{ $tripsStatus == 'in-progress' ? 'selected' : '' }}" href="?status=in-progress"> In Progress
                </a>
                <a class="{{ $tripsStatus == 'done' ? 'selected' : '' }}" href="?status=done"> Done </a>
            </div>
            <dl class="max-w-md divide-y  text-white divide-gray-700">
                @foreach ($trips as $trip)
                    <div class="flex flex-col my-5">
                        <a href="{{ route('driver.trip.view', $trip->id) }}">
                            <dt class="mt-5 text-lg font-semibold">{{ $trip->isPickup() ? 'Pick Up' : 'Shipping' }}</dt>
                            <dd class="text-sm text-gray-400">
                                @if ($trip->isPickup())
                                    From {{ $trip->parts()->count() - 1 }} Warehouse(s) - to
                                    {{ $trip->parts()->where('direction', 1)->first()->part->name }}
                                @else
                                    To {{ $trip->parts()->count() }} Customers
                                @endif
                            </dd>
                        </a>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>


    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Packages
            </div>
            <a class="plus-icon" href="{{ route('driver.add-package.create') }}">
                +
            </a>
        </div>
        <hr />
        <div class="description">
            Packages you currently have
        </div>
        <div class="content">
            <dl class="max-w-md divide-y  text-white divide-gray-700">
                @foreach ($packages as $package)
                    <div class="flex flex-col my-5">
                        <a href="{{ route('driver.view-package', $package->hash) }}">
                            <dt class="mt-5 text-lg font-semibold">#{{ $package->hash }}</dt>
                            <dd class="text-sm text-gray-400">
                                {{ date('Y-m-d | h:i a', strtotime($package->pivot->from)) }}
                            </dd>
                        </a>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</x-delivery::driver-layout>
