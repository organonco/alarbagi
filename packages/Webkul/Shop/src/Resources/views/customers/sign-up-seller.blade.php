{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.signup-form.page-title')" />

    <meta name="keywords" content="@lang('shop::app.customers.signup-form.page-title')" />
@endPush

<x-shop::layouts :has-header="true" :has-feature="false" :has-footer="true">
    {{-- Page Title --}}
    <x-slot:title>
        @lang('marketplace::app.register.title.seller')
    </x-slot>

    <div class="mt-20 max-1180:px-[20px]">

        <div class="flex">

            <div
                class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit">
                <h1 class="sn-color-primary sn-heading-1">

                    @lang('marketplace::app.register.title.seller')
                </h1>

                <p class="sn-color-primary sn-heading-3">
                    @lang('marketplace::app.register.desc.seller')
                </p>

                <div class="mt-[60px] rounded max-sm:mt-[30px]">
                    <x-shop::form :action="route('shop.marketplace.register')" enctype="multipart/form-data">
                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('marketplace::app.register.labels.shop_name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="text" name="name"
                                class="!p-[20px_25px] rounded-lg" :value="old('name')" rules="required" :label="trans('marketplace::app.register.labels.shop_name')"
                                :placeholder="trans('marketplace::app.register.labels.shop_name')">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="name">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('marketplace::app.register.labels.parent_category_select')
                            </x-shop::form.control-group.label>
                            <x-shop::form.control-group.control type="select" name="parent_category_select"
                                onchange="selectedCategory()" id="parent_category_select" class="rounded-lg "
                                style="padding: 20px 40px" :value="old('parent_category_select')" rules="required" :label="trans('marketplace::app.register.labels.parent_category_select')">
                                @foreach ($sellerCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-shop::form.control-group.control>
                            <x-shop::form.control-group.error control-name="parent_category_select">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('marketplace::app.register.labels.seller_category_id')
                            </x-shop::form.control-group.label>
                            <select name="seller_category_id" id="child_category_select"
                                class="rounded-lg custom-select block w-full py-2 px-8 shadow bg-white border border-[#E9E9E9] text-[16px] transition-all hover:border-gray-400 focus:border-gray-400'"
                                style="padding: 20px 40px">
                            </select>

                            <x-shop::form.control-group.error control-name="seller_category_id">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.signup-form.email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="email" name="email"
                                class="!p-[20px_25px] rounded-lg" :value="old('email')" rules="required|email"
                                :label="trans('shop::app.customers.signup-form.email')" placeholder="email@example.com">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="email">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.signup-form.phone')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="text" name="phone"
                                class="!p-[20px_25px] rounded-lg" :value="old('phone')" rules="required|phone"
                                :label="trans('shop::app.customers.signup-form.phone')" placeholder="23456789">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="phone">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.signup-form.landline')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="text" name="landline"
                                class="!p-[20px_25px] rounded-lg" :value="old('landline')" rules="required|phone"
                                :label="trans('shop::app.customers.signup-form.landline')" placeholder="23456789">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="landline">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('marketplace::app.register.labels.area_id')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="select" name="area_id" class="rounded-lg"
                                style="padding: 20px 40px" :value="old('area_id')" rules="required" :label="trans('marketplace::app.register.labels.area_id')">
                                @foreach ($areas as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="name">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.signup-form.address')
                            </x-shop::form.control-group.label>
                            <x-shop::form.control-group.control type="textarea" name="address"
                                class="!p-[20px_25px] rounded-lg" rules="required" :value="old('address')" :label="trans('shop::app.customers.signup-form.address')"
                                placeholder="">
                            </x-shop::form.control-group.control>
                            <x-shop::form.control-group.error control-name="address">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>


                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.signup-form.password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control type="password" name="password"
                                class="!p-[20px_25px] rounded-lg" :value="old('password')" rules="required|min:8"
                                ref="password" :label="trans('shop::app.customers.signup-form.password')" :placeholder="trans('shop::app.customers.signup-form.password')" autocomplete="new-password">
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="password">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>


                        <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                            <button class="block w-full max-w-[1260px] sn-button-primary" type="submit">
                                @lang('shop::app.customers.signup-form.button-title')
                            </button>
                        </div>


                    </x-shop::form>
                </div>

                <p class="my-[20px] text-[#6E6E6E] font-medium">
                    @lang('shop::app.customers.signup-form.account-exists')

                    <a class="text-navyBlue" href="{{ route('admin.session.create') }}">
                        @lang('shop::app.customers.signup-form.sign-in-button')
                    </a>
                </p>
            </div>


        </div>

    </div>

    @push('scripts')
        <script>
            let categories = {!! json_encode($sellerCategories->toArray(), JSON_HEX_TAG) !!}

            function selectedCategory() {

                var parent_category_select = document.getElementById('parent_category_select')
                var child_category_select = document.getElementById('child_category_select')

                for (var count = child_category_select.options.length; count > 0; count--)
                    child_category_select.options.remove(count - 1);

                for (var i = 0; i < categories.length; i++) {
                    if (categories[i].id != parent_category_select.value)
                        continue
                    for (var j = 0; j < categories[i].children.length; j++) {
                        var option = document.createElement("option")
                        option.text = categories[i].children[j].name;
                        option.value = categories[i].children[j].id;
                        child_category_select.options.add(option, j);
                    }
                }




            }
        </script>
    @endpush
</x-shop::layouts>
