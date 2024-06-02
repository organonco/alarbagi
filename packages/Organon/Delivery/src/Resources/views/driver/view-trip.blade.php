<x-delivery::driver-layout>

    <div id="tripModal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                        @if ($trip->isPending())
                            Start Trip
                        @elseif($trip->isInProgress())
                            Finish Trip
                        @endif
                    </h3>
                    <button type="button" id="xButton"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-6 p-6 flex flex-col items-center">
                    @if ($trip->isPending())
                        Are you sure you want to start this trip
                    @elseif($trip->isInProgress())
                        Are you sure you want to finish this trip
                    @endif
                </div>
                <div
                    class="flex items-center space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600 justify-between mx-6">
                    @if ($trip->isPending())
                        <form method="POST" action="{{ route('driver.trip.start', $trip->id) }}">
                            @csrf
                            <button type="submit"
                                class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Yes
                            </button>
                        </form>
                    @elseif($trip->isInProgress())
                        <form method="POST" action="{{ route('driver.trip.finish', $trip->id) }}">
                            @csrf
                            <button type="submit"
                                class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Yes
                            </button>
                        </form>
                    @endif
                    <button type="button" id="cancelButton"
                        class=" px-5 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Trip Details
            </div>

            @if ($trip->isPending())
                <button id="modalButton" class="mx-4 bg-slate-600 rounded-full px-4 py-1 text-base text-emerald-400">
                    START
                </button>
            @elseif($trip->isInProgress())
                <button id="modalButton" class="mx-4 bg-slate-600 rounded-full px-4 py-1 text-base text-emerald-400">
                    FINISH
                </button>
            @endif
        </div>
        <hr />
        <div class="description">
            {!! $trip->getStatusString() !!}
        </div>
        @if ($trip->isPickup())
            <div class="content">
                <div class="text-lg font-bold border-t-gray-600 border-t-2 pt-8">
                    Pick Up From
                </div>
                <div class="text-base pb-4">
                    @foreach ($trip->parts()->where('direction', 0)->get() as $part)
                        <div class="my-8">
                            {!! $part->part->getWarehouseDetailsHTML() !!}
                        </div>
                    @endforeach
                </div>

                <div class="text-lg font-bold border-t-gray-600 border-t-2 pt-8">
                    Drop off At
                </div>
                <div class="text-base pb-4">
                    @foreach ($trip->parts()->where('direction', 1)->get() as $part)
                        <div class="my-8">
                            {!! $part->part->getWarehouseDetailsHTML() !!}
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="content">
                <div class="text-lg font-bold border-t-gray-600 border-t-2 pt-4">
                    Packages To Ship
                </div>
                <div class="text-base border-b-gray-600 border-b-2 pb-4">
                    @foreach ($trip->parts as $part)
                        <div class="my-8">
                            Package #{{ $part->part->package->hash }}
                            <br />
                            <span class="underline">Warehouse:</span>
                            <br />
                            {!! $part->part->package->getCurrentHolder()->getWarehouseDetailsHTML() !!}
                            <br />
                            <span class="underline">Customer:</span>
                            <br />
                            <span class="font-bold"> {!! $part->part->order->shipping_address->name !!}</span> - {!! $part->part->order->shipping_address->full_address !!}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>



    @push('scripts')
        <script type="module">
            const $targetEl = document.getElementById('tripModal');
            const options = {
                placement: 'bottom-right',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
            };
            const instanceOptions = {
                id: 'tripModal',
                override: true
            };
            const modal = new Modal($targetEl, options, instanceOptions);
            const xButton = document.getElementById("xButton")
            const cancelButton = document.getElementById("cancelButton")

            xButton.onclick = () => {
                modal.hide()
            }
            cancelButton.onclick = () => {
                modal.hide()
            }

            const modalButton = document.getElementById("modalButton")
            modalButton.onclick = () => {
                if (!modal.isVisible())
                    modal.show()
            }
        </script>
    @endpush

</x-delivery::driver-layout>
