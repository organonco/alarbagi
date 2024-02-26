<x-admin::layouts>
    <x-slot:title>
        Invoice Preview For {{$invoice->seller->name}}
    </x-slot:title>

    @push('styles')
        <style>
            .info-table td {
                text-align: center;
                border: 1px solid #ddd;
            }

            .info-table th {
                text-align: center;
                border: 1px solid #ddd;
            }

            .info-table {
                border-collapse: collapse;
                width: 100%;
            }

            .info-table tr {

            }
        </style>
    @endpush


    {{-- Header --}}
    <div class="grid mt-[20px]">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <div class="flex gap-[10px] items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                    Invoice Preview For {{$invoice->seller->name}}
                </p>

                <div>
                    <span
                        class="label-{{trans('marketplace::app.seller-invoice.statuses.'. $invoice->status->name . '.class')}} text-[14px] mx-[5px]">
                        @lang('marketplace::app.seller-invoice.statuses.'. $invoice->status->name . '.label')
                    </span>
                </div>
            </div>

            <div style="display: flex">

                @if($is_owner)
                    @if($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::DRAFT)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.destroy', $invoice->id)">
                            <button class="secondary-button" style="color: red; border-color: red; margin-right: 10px"
                                    type="submit">
                                Delete
                            </button>
                        </x-admin::form>
                        <x-admin::form :action="route('admin.sales.sellers.invoice.send', $invoice->id)">
                            <button class="primary-button" type="submit">
                                Send To Seller
                            </button>
                        </x-admin::form>
                    @elseif($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::PENDING)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.unsend', $invoice->id)">
                            <button class="primary-button" type="submit">
                                Undo Send To Seller
                            </button>
                        </x-admin::form>
                    @elseif($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::APPROVED)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.issue', $invoice->id)">
                            <button class="primary-button" type="submit">
                                Issue
                            </button>
                        </x-admin::form>
                    @elseif($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::REJECTED)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.unsend', $invoice->id)">
                            <button class="primary-button" type="submit">
                                Edit
                            </button>
                        </x-admin::form>
                    @endif
                @endif

                @if(!$is_owner)
                    @if($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::PENDING ||  $invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::APPROVED)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.reject', $invoice->id)">
                            <button class="primary-button" style="background-color: darkred; border: none"
                                    type="submit">
                                Reject
                            </button>
                        </x-admin::form>
                    @endif
                    @if($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::PENDING ||  $invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::REJECTED)
                        <x-admin::form :action="route('admin.sales.sellers.invoice.approve', $invoice->id)">
                            <button class="primary-button" style="margin-left: 20px;" type="submit">
                                Accept
                            </button>
                        </x-admin::form>
                    @endif
                @endif
            </div>


        </div>
    </div>

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            Summary
                        </p>

                        <div class="info-box text-gray-800 dark:text-white">
                            <table class="info-table">
                                <tr>
                                    <td style="width: 90%; height: 50px; font-weight: bolder">
                                        Subtotal
                                    </td>
                                    <td style="width: 10%; font-weight: bolder">
                                        {{$invoice->subtotal}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; height: 50px; font-weight: bolder">
                                        Extras
                                    </td>
                                    <td style="width: 10%; font-weight: bolder">
                                        {{$invoice->extras}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; height: 50px; font-weight: bolder">
                                        Fees
                                    </td>
                                    <td style="width: 10%; font-weight: bolder">
                                        {{$invoice->fees}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; height: 50px; font-weight: bolder">
                                        Total
                                    </td>
                                    <td style="width: 10%; font-weight: bolder">
                                        {{$invoice->total}}
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            @if($invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::DRAFT && $is_owner)
                <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                    <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                        <div class="p-[16px]">
                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                                Add Item
                            </p>

                            <x-admin::form :action="route('admin.sales.sellers.invoice.add_item', $invoice->id)">
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="comment"
                                        placeholder="For"
                                        label="For"
                                    >
                                    </x-admin::form.control-group.control>
                                    <x-shop::form.control-group.error
                                        control-name="comment"></x-shop::form.control-group.error>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.control
                                        type="number"
                                        name="amount"
                                        placeholder="Amount"
                                        label="Amount"
                                    >
                                    </x-admin::form.control-group.control>
                                    <x-shop::form.control-group.error
                                        control-name="amount"></x-shop::form.control-group.error>
                                </x-admin::form.control-group>
                                <div class="flex gap-[36px] flex-wrap items-center mt-[20px]">
                                    <button
                                        class="primary-button py-[8px] w-full block px-[43px] mx-auto m-0 ml-[0px] rounded-[18px] text-[16px] text-center"
                                        type="submit"
                                    >
                                        Add Item
                                    </button>
                                </div>
                            </x-admin::form>
                        </div>
                    </div>
                </div>
            @endif

        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            Items
                        </p>
                        <div class="info-box text-gray-800 dark:text-white">
                            <table class="info-table">
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td style="width: 90%; height: 50px">
                                            {{$item['comment']}}
                                        </td>
                                        <td style="width: 8%; height: 50px">
                                            {{$item->amount}}
                                        </td>
                                        @if($is_owner && $invoice->status == \Organon\Marketplace\Enums\SellerInvoiceStatusEnum::DRAFT && $item->type == \Organon\Marketplace\Enums\SellerInvoiceItemTypeEnum::EXTRA)
                                            <td style="width: 2%; height: 50px">
                                                <x-admin::form
                                                    :action="route('admin.sales.sellers.invoice.delete_item', ['invoice_id' => $invoice->id, 'item_id' => $item->id])"
                                                    method="DELETE"
                                                    ref="delete_item_form">
                                                    <button type="submit"
                                                            class="icon-delete rounded-[6px] text-[24px] peer-checked:icon-checked peer-checked:text-blue-600">
                                                    </button>
                                                </x-admin::form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</x-admin::layouts>
