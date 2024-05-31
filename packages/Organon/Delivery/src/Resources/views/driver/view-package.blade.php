<x-delivery::driver-layout>
    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Package #{{ $package->hash }}
            </div>
        </div>
        <hr />
        <div class="description">
            {{ $package->number_of_items }} Items
            {{-- Current Holder: {{ $package->getCurrentHolder()->getName() }} --}}
        </div>
        <div class="content">
            <div class="text-lg font-bold border-t-gray-600 border-t-2 pt-4">
                Content
            </div>
            <div class="text-base border-b-gray-600 border-b-2 pb-4">
                @foreach ($package->orderItems as $item)
                    <div>
                        - {{ $item->name . ' (x' . $item->qty_ordered . ')' }}
                    </div>
                @endforeach
            </div>
            <ol class="relative border-s border-gray-700">
                @foreach ($package->transactions as $transaction)
                    <li class="my-5 ms-4">
                        <div class="absolute w-3 h-3 rounded-full mt-1.5 -start-1.5 border  border-gray-900 bg-gray-700">
                        </div>
                        <time
                            class="mb-1 text-sm font-normal leading-none text-gray-500">{{ date('Y-m-d | h:i a', strtotime($transaction->from)) }}</time>
                        <h3 class="text-lg font-semibold text-white">{{ $transaction->holder->getName() }}</h3>
                    </li>
                @endforeach
            </ol>
        </div>


</x-delivery::driver-layout>
