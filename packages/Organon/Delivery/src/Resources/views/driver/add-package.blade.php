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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-48">
                    <path fill="white"
                        d="M52 33a2 2 0 0 0-2 2v15.646l-21 8.4V33.354l2.505-1.002a2 2 0 0 0-1.486-3.714L27 29.846l-6.965-2.786 10.012-4.668a2 2 0 1 0-1.69-3.625L14.94 25.022 7.385 22 27 14.154l2.346.938a2 2 0 1 0 1.484-3.714l-3.088-1.235a2.002 2.002 0 0 0-1.485 0l-25 10A2 2 0 0 0 0 22v30a2 2 0 0 0 1.257 1.857l25 10a2.001 2.001 0 0 0 1.486 0l25-10A2 2 0 0 0 54 52V35a2 2 0 0 0-2-2ZM4 24.954l9 3.6V39.36a2 2 0 0 0 4 0v-9.205l8 3.2v25.692l-21-8.4Zm35.857 25.303a2 2 0 0 1-1.114 2.6l-5 2a2 2 0 1 1-1.486-3.713l5-2a2 2 0 0 1 2.6 1.113Zm-1.114-3.4-5 2a2 2 0 1 1-1.486-3.713l5-2a2 2 0 1 1 1.486 3.713Z" />
                    <path fill="#5a4ef6"
                        d="M59.214 0H38.786A4.792 4.792 0 0 0 34 4.786v20.428A4.792 4.792 0 0 0 38.786 30h20.428A4.792 4.792 0 0 0 64 25.214V4.786A4.792 4.792 0 0 0 59.214 0ZM60 25.214a.787.787 0 0 1-.786.786H38.786a.787.787 0 0 1-.786-.786V4.786A.787.787 0 0 1 38.786 4h20.428a.787.787 0 0 1 .786.786ZM39 12V7a2 2 0 0 1 2-2h5a2 2 0 0 1 0 4h-3v3a2 2 0 0 1-4 0Zm20 6v5a2 2 0 0 1-2 2h-5a2 2 0 0 1 0-4h3v-3a2 2 0 0 1 4 0Zm-12-3h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2Zm-2 6h-2v-2h2ZM57 5h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2Zm-2 6h-2V9h2Zm-7 1a2 2 0 1 1-2-2 2 2 0 0 1 2 2Zm2 6a2 2 0 1 1 2 2 2 2 0 0 1-2-2Z" />
                </svg>
            </div>
            <div class="hidden my-12" id="qrScannerDiv">
                <video id="qrScanner"></video>
            </div>
            <div class="font-black text-white my-4 text-center mt-4 hidden">
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
                Toastify({
                    text: "Package #" + hash.replace("#", '') + " was added",
                    duration: 3000,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    style: {
                        background: "#00b09b",
                    },
                }).showToast();
            }

            const showErrorNotification = () => {
                Toastify({
                    text: "Something went wrong",
                    duration: 3000,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    style: {
                        background: "red",
                    },
                }).showToast();
            }



            const submit = (hash) => {
                axios.post("{{ route('driver.add-package.store') }}", {
                    'hash': hash
                }).then(() => {
                    showSuccessNotification(hash)
                    modal.hide()
                }).catch((error) => {
                    console.log(error)
                    showErrorNotification()
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
