<x-delivery::warehouse-layout>
    <div class="text-green-300 text-yellow-300 text-blue-300"></div>
    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Trips
            </div>
        </div>
        <hr />
        <div class="description">
            Drivers coming your way to pickup packages
        </div>

        <div class="content">
            <dl class="max-w-md divide-y   divide-gray-700">
                @foreach ($trips as $trip)
                    <div class="flex flex-col my-4">
                        <dt class="text-lg font-semibold mt-4">{{ $trip->driver->name }}</dt>
                        <div class="description">{!! $trip->getStatusString() !!}</div>
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
            <a class="plus-icon" href="{{ route('warehouse.add-package.create') }}">
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
                        <a href="{{ route('warehouse.view-package', $package->hash) }}">
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
</x-delivery::warehouse-layout>
