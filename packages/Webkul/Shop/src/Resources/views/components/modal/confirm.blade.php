<v-modal-confirm ref="confirmModal"></v-modal-confirm>

@pushOnce('scripts')
    <script type="text/x-template" id="v-modal-confirm-template">
        <div>
            <transition
                tag="div"
                name="modal-overlay"
                enter-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity z-[1]"
                    v-show="isOpen"
                ></div>
            </transition>

            <transition
                tag="div"
                name="modal-content"
                enter-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                enter-to-class="opacity-100 translate-y-0 md:scale-100"
                leave-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 md:scale-100"
                leave-to-class="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
            >
                <div
                    class="fixed inset-0 z-10 transform transition overflow-y-auto" v-show="isOpen"
                >
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class=" max-w-[475px] z-[999] absolute left-[50%] top-[50%] p-[20px] rounded-[12px] bg-white overflow-hidden max-md:w-[90%] -translate-x-[50%] -translate-y-[50%]">
                            <div class="flex gap-[10px]">
                                <div>
                                    <span class="flex p-[10px] border border-[rgba(6,12,59,0.20)] rounded-full">
                                        <i class="icon-error text-[28px]"></i>
                                    </span>
                                </div>
                            
                                <div>
                                    <div class="flex gap-[20px] justify-between items-center text-[20px]">
                                        @{{ title }}
                                    </div>

                                    <div class="pt-[5px] pb-[20px] tex-[14px] text-[#727272] text-left">
                                        @{{ message }}
                                    </div>
                                    
                                    <div class="flex gap-[10px] justify-between">
                                        <button type="button" class="sn-button-primary-alt" style="padding: 10px 20px !important" @click="disagree">
                                            @{{ options.btnDisagree }}
                                        </button>

                                        <button type="button" class="sn-button-primary" @click="agree">
                                            @{{ options.btnAgree }} 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </script>

    <script type="module">
        app.component('v-modal-confirm', {
            template: '#v-modal-confirm-template',

            data() {
                return {
                    isOpen: false,

                    title: '',

                    message: '',

                    options: {
                        btnDisagree: '',
                        btnAgree: '',
                    },

                    agreeCallback: null,

                    disagreeCallback: null,
                };
            },

            created() {
                this.registerGlobalEvents();
            },

            methods: {
                open({
                    title = "@lang('shop::app.components.modal.confirm.title')",
                    message = "@lang('shop::app.components.modal.confirm.message')",
                    options = {
                        btnDisagree: "@lang('shop::app.components.modal.confirm.disagree-btn')",
                        btnAgree: "@lang('shop::app.components.modal.confirm.agree-btn')",
                    },
                    agree = () => {},
                    disagree = () => {},
                }) {
                    this.isOpen = true;

                    document.body.style.overflow = 'hidden';

                    this.title = title;

                    this.message = message;

                    this.options = options;

                    this.agreeCallback = agree;
                    
                    this.disagreeCallback = disagree;
                },

                disagree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    this.disagreeCallback();
                },

                agree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    this.agreeCallback();
                },

                registerGlobalEvents() {
                    this.$emitter.on('open-confirm-modal', this.open);
                },
            }
        });
    </script>
@endPushOnce
