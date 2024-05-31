<x-delivery::warehouse-layout>
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
