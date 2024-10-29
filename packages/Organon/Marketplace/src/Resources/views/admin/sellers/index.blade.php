<x-admin::layouts>
    <x-slot:title>
        التجار
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            التجار
        </p>

        <div class="flex gap-x-[10px] items-center">
            <!-- Export Modal -->
            <x-admin::modal ref="qrModal">
                <x-slot:toggle>
                    <button class="text-gray-600 dark:text-gray-300 font-semibold leading-[24px]" onclick="newQr()">
                        QR
                    </button>
                </x-slot:toggle>
                <x-slot:header>
                    <p class="text-[18px] text-gray-800 dark:text-white font-bold">
                        إنشاء QR
                    </p>
                </x-slot:header>
                <x-slot:content>
                    <div class="flex justify-between p-4 hidden" id="qrDiv">
                        <div class="flex flex-col gap-[10px]">
                            <div id="regqr"></div>

                            <p class="text-center">QR التسجيل</p>

                            <a class="primary-button text-center" style="justify-content: space-around"
                                id="regDownloadButton" target="_blank">
                                تحميل
                            </a>

                        </div>
                        <div class="flex flex-col gap-[10px]">
                            <div id="shopqr"></div>
                            <p class="text-center">QR المتجر</p>

                            <a class="primary-button text-center" style="justify-content: space-around"
                                id="shopDownloadButton" target="_blank">
                                تحميل
                            </a>
                        </div>
                    </div>
                </x-slot:content>
                <x-slot:footer>
                    <div class="flex justify-center w-full gap-[10px]">
                        <button class="primary-button" onclick="newQr()" id="newQrButton">
                            QR جديد
                        </button>
                    </div>
                </x-slot:footer>
            </x-admin::modal>
            <x-admin::datagrid.export src="{{ route('admin.sales.sellers.index') }}"></x-admin::datagrid.export>

        </div>
    </div>

    <x-admin::datagrid :src="route('admin.sales.sellers.index')" :isMultiRow="true">
    </x-admin::datagrid>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
            function newQr() {
                let ref = Math.random().toString(36).substring(2, 10);
                document.getElementById("qrDiv").classList.remove('hidden');

                document.getElementById("regqr").innerHTML = "";
                document.getElementById("shopqr").innerHTML = "";


                let regUrl = "{{ route('shop.customers.register.index-seller') }}" + "?ref=" + ref
                let shopUrl = "{{ route('shop.marketplace.show-by-ref', '') }}" + "/" + ref;

                new QRCode(document.getElementById("regqr"), regUrl);
                new QRCode(document.getElementById("shopqr"), shopUrl);

                document.getElementById("regDownloadButton").download = ref + "-تسجيل.png";
                document.getElementById("shopDownloadButton").download = ref + "-متجر.png";

                setTimeout(() => {
                    document.getElementById("regDownloadButton").href = document.getElementById("regqr")
                        .querySelectorAll("img")[0].src
                    document.getElementById("shopDownloadButton").href = document.getElementById("shopqr")
                        .querySelectorAll("img")[0].src
                }, 200);
            }
        </script>
    @endpush
</x-admin::layouts>
