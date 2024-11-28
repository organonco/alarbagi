<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.catalog.products.edit.title')
    </x-slot:title>


    {!! view_render_event('bagisto.admin.catalog.product.edit.before', ['product' => $product]) !!}

    <x-admin::form method="PUT" enctype="multipart/form-data">
        {!! view_render_event('bagisto.admin.catalog.product.edit.actions.before', ['product' => $product]) !!}

        {{-- Page Header --}}
        <div class="grid gap-[10px]">
            <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
                <div class="grid gap-[6px]">
                    <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                        @lang('admin::app.catalog.products.edit.title')
                    </p>
                </div>

                <div class="flex gap-x-[10px] items-center">
                    <a href="{{ route('admin.catalog.products.index') }}"
                        class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white ">
                        @lang('admin::app.account.edit.back-btn')
                    </a>

                    <button class="primary-button">
                        @lang('admin::app.catalog.products.edit.save-btn')
                    </button>
                </div>
            </div>
        </div>

        @php

            $currentChannel = core()->getRequestedChannel();

            $currentLocale = core()->getRequestedLocale();
        @endphp

        <input type="hidden" name="channel" value="{{ $currentChannel->code }}" />
        <input type="hidden" name="locale" value="{{ $currentLocale->code }}" />


        {!! view_render_event('bagisto.admin.catalog.product.edit.actions.after', ['product' => $product]) !!}

        <!-- body content -->
        {!! view_render_event('bagisto.admin.catalog.product.edit.form.before', ['product' => $product]) !!}

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            @foreach ($product->attribute_family->attribute_groups->groupBy('column') as $column => $groups)
                {!! view_render_event('bagisto.admin.catalog.product.edit.form.column_' . $column . '.before', [
                    'product' => $product,
                ]) !!}

                <div @if ($column == 1) class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto" @endif
                    @if ($column == 2) class="flex flex-col gap-[8px] w-[360px] max-w-full max-sm:w-full" @endif>
                    @foreach ($groups as $group)
                        @php
                            $customAttributes = $product->getEditableAttributes($group);
                        @endphp
                        @if (count($customAttributes) && $group->is_user_defined)
                            {!! view_render_event('bagisto.admin.catalog.product.edit.form..' . $group->name . '.before', [
                                'product' => $product,
                            ]) !!}

                            <div class="relative p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                                <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                                    {{ $group->name }}
                                </p>

                                @foreach ($customAttributes as $attribute)
                                    @if (!in_array($attribute->code, ['sku', 'url_key', 'manage_stock']))
                                        {!! view_render_event('bagisto.admin.catalog.product.edit.form.' . $group->name . '.controls.before', [
                                            'product' => $product,
                                        ]) !!}

                                        <x-admin::form.control-group>
                                            <x-admin::form.control-group.label>
                                                {{ $attribute->admin_name . ($attribute->is_required ? '*' : '') }}
                                            </x-admin::form.control-group.label>

                                            @include ('admin::catalog.products.edit.controls', [
                                                'attribute' => $attribute,
                                                'product' => $product,
                                            ])

                                            <x-admin::form.control-group.error
                                                :control-name="$attribute->code"></x-admin::form.control-group.error>
                                        </x-admin::form.control-group>

                                        {!! view_render_event('bagisto.admin.catalog.product.edit.form.' . $group->name . '.controls.before', [
                                            'product' => $product,
                                        ]) !!}
                                    @endif
                                @endforeach

                            </div>

                            {!! view_render_event('bagisto.admin.catalog.product.edit.form.' . $group->name . '.after', [
                                'product' => $product,
                            ]) !!}
                        @endif
                    @endforeach

                    @if ($column == 1)
                        {{-- Images View Blade File --}}
                        @include('admin::catalog.products.edit.images')
                    @else
                        <div class="relative p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                                أنواع المنتج
                            </p>
                            <div id="variants">
                                @foreach ($product->variants as $variant)
                                    <div class="flex gap-[6px]">
                                        <input type="hidden" name="varient_ids[]" value="{{ $variant->id }}">
                                        <input value="{{ $variant->label }}" name="varient_label[]"
                                            placeholder="الوزن - النكهة - اللون ..."
                                            class="flex min-h-[39px] py-2 px-3 border rounded-[6px] text-[14px] text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800">
                                        <input value="{{ $variant->price }}" name="varient_price[]" placeholder="السعر"
                                            class="flex w-full min-h-[39px] py-2 px-3 border rounded-[6px] text-[14px] text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800">
                                        <button onclick="this.parentNode.remove();">حذف</button>
                                    </div>
                                @endforeach
                                <div class="gap-[6px] hidden" id="variantInput">
                                    <input type="hidden" name="varient_ids[]">
                                    <input name="varient_label[]" placeholder="الوزن - النكهة - اللون ..."
                                        class="flex min-h-[39px] py-2 px-3 border rounded-[6px] text-[14px] text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800">
                                    <input name="varient_price[]" placeholder="السعر"
                                        class="flex w-full min-h-[39px] py-2 px-3 border rounded-[6px] text-[14px] text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800">
                                    <button onclick="this.parentNode.remove();">حذف</button>
                                </div>
                            </div>
                            <button class="mt-[14px]" onclick="addVariantInput(event)">إضافة نوع</button>
                        </div>
                    @endif
                </div>

                {!! view_render_event('bagisto.admin.catalog.product.edit.form.column_' . $column . '.after', [
                    'product' => $product,
                ]) !!}
            @endforeach
        </div>

        {!! view_render_event('bagisto.admin.catalog.product.edit.form.after', ['product' => $product]) !!}
    </x-admin::form>

    {!! view_render_event('bagisto.admin.catalog.product.edit.after', ['product' => $product]) !!}

    @push('scripts')
        <script>
            function addVariantInput(event) {
                event.preventDefault();

                // var div = document.createElement("div");
                // div.classList = ['flex gap-[6px]']

                // var labelInput = document.createElement('input');
                // var priceInput = document.createElement('input');

                // div.append(labelInput);
                // div.append(priceInput);

                // document.getElementById('variants').append(div);


                var div = document.getElementById("variantInput")
                var divv = div.cloneNode(true);

                divv.classList.remove('hidden')
                divv.classList.add('flex')
                document.getElementById('variants').append(divv);
            }
        </script>
    @endpush

</x-admin::layouts>
