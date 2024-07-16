<x-admin::layouts.anonymous>
    {{-- Page Title --}}
    <x-slot:title>
        {{ __('تسجيل الدخول') }}
    </x-slot:title>

    <div class="flex justify-center items-center h-[100vh]">
        <div class="flex flex-col gap-[20px] items-center">
            {{-- Logo --}}
            <img width="250" src="{{ asset('assets/images/logo.png') }}" alt="Logo">

            <div class="flex flex-col min-w-[300px] bg-white dark:bg-gray-900 rounded-[6px] box-shadow">
                {{-- Login Form --}}
                <x-admin::form :action="route('shipping.session.store')">
                    <div class="p-[16px]  ">
                        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                            {{ __('تسجيل دخول شركة توصيل') }}
                        </p>
                    </div>

                    <div class="p-[16px] border-t-[1px] border-b-[1px] dark:border-gray-800">
                        <div class="mb-[10px]">
                            {{-- Email --}}
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.sessions.username')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control type="text" name="username" id="username"
                                    class="w-[254px] max-w-full" rules="required" :label="trans('admin::app.users.sessions.username')"
                                    :placeholder="trans('admin::app.users.sessions.username')">
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.error control-name="username">
                                </x-admin::form.control-group.error>
                            </x-admin::form.control-group>
                        </div>

                        {{-- Password --}}
                        <div class="relative w-full">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.sessions.password')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control type="password" name="password" id="password"
                                    class="w-[254px] max-w-full ltr:pr-10 rtl:pl-10" rules="required|min:6"
                                    :label="trans('admin::app.users.sessions.password')" :placeholder="trans('admin::app.users.sessions.password')">
                                </x-admin::form.control-group.control>

                                <span
                                    class="icon-view text-[22px] cursor-pointer absolute top-[42px] transform -translate-y-1/2 ltr:right-2 rtl:left-2"
                                    onclick="switchVisibility()" id="visibilityIcon">
                                </span>

                                <x-admin::form.control-group.error control-name="password">
                                </x-admin::form.control-group.error>
                            </x-admin::form.control-group>
                        </div>
                    </div>
                    <div class="flex justify-between items-center p-[16px]">
                        {{-- Forgot Password Link --}}
                        <div class="text-[12px] text-blue-600 font-semibold leading-[24px] cursor-pointer"></div>
                        <button class="sn-button-primary">
                            @lang('admin::app.users.sessions.submit-btn')
                        </button>
                    </div>
                </x-admin::form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let visibilityIcon = document.getElementById("visibilityIcon");

                passwordField.type = passwordField.type === "password" ? "text" : "password";
                visibilityIcon.classList.toggle("icon-view-close");
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>
