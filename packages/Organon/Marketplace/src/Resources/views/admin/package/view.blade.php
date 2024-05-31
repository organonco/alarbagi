<x-admin::layouts>
    <x-slot:title>
        {{ __('Package #' . $package->hash) }}
    </x-slot:title>

    {{-- Header --}}
    <div class="grid">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <div class="flex gap-[10px] items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                    {{ __('Package #' . $package->hash) }}
                </p>
            </div>

            {{-- Back Button --}}
            <a onclick="history.back()"
                class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white">
                @lang('admin::app.account.edit.back-btn')
            </a>
        </div>
    </div>

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">

        {{-- Order details --}}
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            {{-- Left Component --}}
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="flex justify-between p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                            Package Holders
                        </p>
                    </div>

                    {{-- Order items --}}
                    <div class="grid">
                        @foreach ($package->transactions as $transaction)
                            <div
                                class="flex gap-[10px] justify-between px-[16px] py-[16px] border-b-[1px] border-slate-300 dark:border-gray-800">
                                <div class="flex gap-[10px]">
                                    <div class="grid gap-[6px] place-content-start">
                                        <h3 class="text-lg font-semibold dark:text-white ">
                                            {{ $transaction->holder->getName() }}
                                        </h3>

                                        <div class="flex flex-col gap-[6px] place-items-start">
                                            <p class="text-gray-600 dark:text-gray-300">
                                                <time
                                                    class="mb-1 text-sm font-normal leading-none text-gray-500">{{ date('Y-m-d | h:i a', strtotime($transaction->from)) }}</time>
                                                -
                                                <time
                                                    class="mb-1 text-sm font-normal leading-none text-gray-500">{{ is_null($transaction->until) ? 'NOW' : date('Y-m-d | h:i a', strtotime($transaction->until)) }}</time>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Right Component --}}
            <div class="flex flex-col gap-[8px] w-[360px] max-w-full max-sm:w-full">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="flex justify-between p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[8px]">
                            Package Content
                        </p>
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                            {{ $package->number_of_items }} Items
                        </p>
                    </div>

                    {{-- Order items --}}
                    <div class="grid">
                        @foreach ($package->sellerOrder->items as $item)
                            <div
                                class="flex gap-[10px] justify-between px-[16px] py-[24px] border-b-[1px] border-slate-300 dark:border-gray-800">
                                <div class="flex gap-[10px]">
                                    <div class="grid gap-[6px] place-content-start">
                                        <p class="text-[16x] text-gray-800 dark:text-white font-semibold">
                                            {{ $item->name }} (x{{ $item->qty_ordered }})
                                        </p>

                                        <div class="flex flex-col gap-[6px] place-items-start">
                                            <p class="text-gray-600 dark:text-gray-300">
                                                @lang('admin::app.sales.orders.view.sku', ['sku' => $item->sku])
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>

</x-admin::layouts>
