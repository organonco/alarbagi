<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header flex flex-row justify-between">
            السائقين
            <a class="plus-icon" href="{{ route('shipping.driver.create') }}">
                +
            </a>
        </div>
        <hr />
        <div class="content">
            <ul class="data">
                @foreach ($drivers as $driver)
                    <a href="{{ route('shipping.driver.edit', $driver->id) }}">
                        <li>
                            <div class="title">
                                {{ $driver->name }} - <span dir="ltr">{{ $driver->phone }}</span>
                            </div>
                            <div class="info">
                                {{ $driver->info }}
                            </div>
                            <hr />
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</x-delivery::layouts.shipping>
