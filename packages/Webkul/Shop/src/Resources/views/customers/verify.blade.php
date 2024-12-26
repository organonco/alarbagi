{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="تأكيد الحساب" />
    <meta name="keywords" content="تأكيد الحساب" />
@endPush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        تأكيد الحساب
    </x-slot>

    <div class="container mt-20 max-1180:px-[20px]">
        <div class="flex">
            <div
                class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit">

                <img src="{{ asset('assets/images/logo.png') }}" class="mx-auto mb-12 lg:w-[40%] w-[70%]" />

                <h1 class="sn-color-primary sn-heading-1">

                    تأكيد الحساب
                </h1>

                <p class="sn-color-primary sn-heading-4">
                    ستصلك رسالة SMS إلى رقمك فيها رمز التأكيد
                </p>

                <div class="mt-[60px] rounded max-sm:mt-[30px]">
                    <x-shop::form enctype="multipart/form-data">
                        <x-shop::form.control-group class="mb-4">
                            <x-shop::form.control-group.label class="required">
                                رمز التأكيد
                            </x-shop::form.control-group.label>
                            <x-shop::form.control-group.control type="text" name="code"
                                class="!p-[20px_25px] rounded-lg" rules="required" :label="'رمز التأكيد'" :placeholder="'رمز التأكيد'">
                            </x-shop::form.control-group.control>
                            <x-shop::form.control-group.error control-name="code">
                            </x-shop::form.control-group.error>
                        </x-shop::form.control-group>
                        <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                            <button class="block w-full max-w-[1260px] sn-button-primary" type="submit"
                                id="registerButton">
                                تأكيد
                            </button>
                        </div>
                    </x-shop::form>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts>
