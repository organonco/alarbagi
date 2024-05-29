<x-delivery::layout>
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
            @foreach ($packages as $package)
                <div>
                    Package #{{ $package->hash }}
                </div>
            @endforeach
        </div>
    </div>
</x-delivery::layout>
