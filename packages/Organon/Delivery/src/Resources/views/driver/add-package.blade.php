<x-delivery::driver-layout>
    <div class="card">
        <div class="header flex flex-row justify-between">
            <div>
                Add Package
            </div>
        </div>
        <hr />
        <div class="description">
            By adding a package, you confirm that you will be the next holder
        </div>
        <div class="content mt-12">
            <div class="font-normal text-white mb-2 text-center">
                Scan QR
            </div>
            <div class="w-full flex flex-col items-center my-12" id="scannerButton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 123 123" class="w-48">
                    <path style="fill-rule:evenodd;" fill="white"
                        d="M26.68,26.77H51.91V51.89H26.68V26.77ZM35.67,0H23.07A22.72,22.72,0,0,0,14.3,1.75a23.13,23.13,0,0,0-7.49,5l0,0a23.16,23.16,0,0,0-5,7.49A22.77,22.77,0,0,0,0,23.07V38.64H10.23V23.07a12.9,12.9,0,0,1,1-4.9A12.71,12.71,0,0,1,14,14l0,0a12.83,12.83,0,0,1,9.07-3.75h12.6V0ZM99.54,0H91.31V10.23h8.23a12.94,12.94,0,0,1,4.9,1A13.16,13.16,0,0,1,108.61,14l.35.36h0a13.07,13.07,0,0,1,2.45,3.82,12.67,12.67,0,0,1,1,4.89V38.64h10.23V23.07a22.95,22.95,0,0,0-6.42-15.93h0l-.37-.37a23.16,23.16,0,0,0-7.49-5A22.77,22.77,0,0,0,99.54,0Zm23.07,99.81V82.52H112.38V99.81a12.67,12.67,0,0,1-1,4.89,13.08,13.08,0,0,1-2.8,4.17,12.8,12.8,0,0,1-9.06,3.78H91.31v10.23h8.23a23,23,0,0,0,16.29-6.78,23.34,23.34,0,0,0,5-7.49,23,23,0,0,0,1.75-8.8ZM23.07,122.88h12.6V112.65H23.07A12.8,12.8,0,0,1,14,108.87l-.26-.24a12.83,12.83,0,0,1-2.61-4.08,12.7,12.7,0,0,1-.91-4.74V82.52H0V99.81a22.64,22.64,0,0,0,1.67,8.57,22.86,22.86,0,0,0,4.79,7.38l.31.35a23.2,23.2,0,0,0,7.5,5,22.84,22.84,0,0,0,8.8,1.75Zm66.52-33.1H96v6.33H89.59V89.78Zm-12.36,0h6.44v6H70.8V83.47H77V77.22h6.34V64.76H89.8v6.12h6.12v6.33H89.8v6.33H77.23v6.23ZM58.14,77.12h6.23V70.79h-6V64.46h6V58.13H58.24v6.33H51.8V58.13h6.33V39.33h6.43V58.12h6.23v6.33h6.13V58.12h6.43v6.33H77.23v6.33H70.8V83.24H64.57V95.81H58.14V77.12Zm31.35-19h6.43v6.33H89.49V58.12Zm-50.24,0h6.43v6.33H39.25V58.12Zm-12.57,0h6.43v6.33H26.68V58.12ZM58.14,26.77h6.43V33.1H58.14V26.77ZM26.58,70.88H51.8V96H26.58V70.88ZM32.71,77h13V89.91h-13V77Zm38-50.22H95.92V51.89H70.7V26.77Zm6.13,6.1h13V45.79h-13V32.87Zm-44,0h13V45.79h-13V32.87Z" />
                </svg>
            </div>
            <div class="hidden my-12" id="qrScannerDiv">
                <video id="qrScanner"></video>
            </div>
            <div class="font-black text-white my-4 text-center mt-4">
                OR
            </div>
            <div class="font-normal text-white mb-2 text-center">
                Add using package #
            </div>
            <div>
                <div class="flex justify-center flex-col items-center content-center">
                    <input type="text"
                        class="bordertext-sm rounded-lg  block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Package #" required id="submitFromInputInput" />
                    <button type="submit" id="submitFromInputButton"
                        class="text-white border-white border-2 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-centerbg-blue-600 hover:bg-blue-700 focus:ring-blue-800 mt-4">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalEl" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                        Add Package
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
                    Are you sure you want to add package <br />
                    <div id="packageNum" class="font-black text-lg"></div>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex items-center space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600 justify-between mx-6">
                    <input type="hidden" id="submitFromQrInput">
                    <button type="button" id="submitFromQrButton"
                        class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Yes
                    </button>
                    <button type="button" id="cancelButton"
                        class=" px-5 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script type="module">
            const showSuccessNotification = (hash) => {
                showNotification("Package #" + hash.replace("#", '') + " was added", "#00b09b")
            }

            const showNotification = (message, color) => {
                Toastify({
                    text: message,
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: color,
                    },
                }).showToast();
            }



            const submit = (hash) => {
                if (!hash) {
                    showNotification("Package # is required", "red")
                    return;
                }
                axios.post("{{ route('driver.add-package.store') }}", {
                    'hash': hash
                }).then(() => {
                    showSuccessNotification(hash)
                    modal.hide()
                }).catch((error) => {
                    if (error.response.status == 404)
                        showNotification("Package Not Found", "red")
                    else
                        showNotification("Something went wrong", "red")
                })
            }

            const submitFromInputButton = document.getElementById("submitFromInputButton")
            const submitFromInputInput = document.getElementById("submitFromInputInput")
            const submitFromQrInput = document.getElementById("submitFromQrInput")
            const submitFromQrButton = document.getElementById("submitFromQrButton")

            submitFromInputButton.onclick = () => {
                submit(submitFromInputInput.value);
            }
            submitFromQrButton.onclick = () => {
                submit(submitFromQrInput.value);
            }


            //Modal
            const $targetEl = document.getElementById('modalEl');
            const packageNum = document.getElementById("packageNum")
            const options = {
                placement: 'bottom-right',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
            };
            const instanceOptions = {
                id: 'modalEl',
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


            const openModal = (hash) => {
                if (modal.isVisible())
                    return;
                packageNum.innerHTML = "#" + hash
                submitFromQrInput.value = hash
                modal.show()
            }


            // QR Scanner
            const scannerDiv = document.getElementById('qrScannerDiv');
            const scannerElement = document.getElementById('qrScanner');
            const scannerButton = document.getElementById("scannerButton")

            scannerButton.onclick = () => {
                qrScanner.start()
                scannerDiv.classList.remove('hidden')
                scannerButton.classList.add("hidden")
            };
            const qrScanner = new QrScanner(
                scannerElement,
                result => openModal(result['data']), {},
            );
        </script>
    @endpush
</x-delivery::driver-layout>
