<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.notifications.title')
    </x-slot:title>

    {!! view_render_event('bagisto.admin.marketing.notifications.create.before') !!}

    {{-- Vue Component --}}
    <v-notification-list></v-notification-list>

    {!! view_render_event('bagisto.admin.marketing.notifications.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-notification-list-template"
        >
                <div class="flex gap-[16px] justify-between items-center mb-[20px] max-sm:flex-wrap">
                    <div class="grid gap-[6px]">
                        <p class="pt-[6px] text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                            @lang('admin::app.notifications.title')
                        </p>

                        <p class="text-gray-600 dark:text-gray-300">
                            @lang('admin::app.notifications.description-text')
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-[6px] box-shadow w-full">
                    <div class="w-full">

                        <div
                            class="grid max-h-[calc(100vh-330px)] overflow-auto journal-scroll w-full"
                            v-if="notifications.length"
                        >
                            <a
                                :href="notification.url"
                                class="flex gap-[5px] p-[16px] items-start hover:bg-gray-50 dark:hover:bg-gray-950"
                                v-for="notification in notifications"
                                :class="notification.read ? 'opacity-50' : ''"
                            >
                                <div class="grid">
                                    <p class="text-gray-800 dark:text-white">
                                        @{{ notification.text }}
                                    </p>
        
                                    <p class="text-[12px] text-gray-600 dark:text-gray-300">
                                        @{{ notification.datetime_diff }}
                                    </p>
                                </div>
                            </a>
                        </div>

                        <!-- For Empty Data -->
                        <div
                            class="px-[24px] py-[12px] max-h-[calc(100vh-330px)]"
                            v-else
                        >
                            @lang('admin::app.notifications.no-record')
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex gap-x-[8px] items-center p-[24px] border-t-[1px] dark:border-gray-800">
                        <div
                            class="inline-flex gap-x-[4px] items-center justify-between ltr:ml-[8px] rtl:mr-[8px] text-gray-600 dark:text-gray-300 py-[6px] px-[8px] leading-[24px] text-center w-full max-w-max bg-white dark:bg-gray-900 border dark:border-gray-800 rounded-[6px] marker:shadow appearance-none focus:ring-2 focus:outline-none focus:ring-black max-sm:hidden" 
                            v-text="pagination.per_page"
                        >
                        </div>

                        <span class="text-gray-600 dark:text-gray-300 whitespace-nowrap">of</span>

                        <p
                            class="text-gray-600 dark:text-gray-300 whitespace-nowrap"
                            v-text="pagination.current_page"
                        >
                        </p>

                        <!-- Prev & Next Page Button -->
                        <div class="flex gap-[4px] items-center">
                            <a @click="getResults()">
                                <div class="inline-flex gap-x-[4px] items-center justify-between ltr:ml-[8px] rtl:mr-[8px] text-gray-600 dark:text-gray-300 p-[6px] text-center w-full max-w-max bg-white dark:bg-gray-900 border rounded-[6px] dark:border-gray-800 cursor-pointer transition-all hover:border hover:bg-gray-100 dark:hover:bg-gray-950 marker:shadow appearance-none focus:ring-2 focus:outline-none focus:ring-black">
                                    <span class="icon-sort-left text-[24px]"></span>
                                </div>
                            </a>

                            <a @click="getResults(pagination.last_page)">
                                <div
                                    class="inline-flex gap-x-[4px] items-center justify-between ltr:ml-[8px] rtl:mr-[8px] text-gray-600 dark:text-gray-300 p-[6px] text-center w-full max-w-max bg-white dark:bg-gray-900 border rounded-[6px] dark:border-gray-800 cursor-pointer transition-all hover:border hover:bg-gray-100 dark:hover:bg-gray-950 marker:shadow appearance-none focus:ring-2 focus:outline-none focus:ring-black">
                                    <span class="icon-sort-right text-[24px]"></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
        </script>

        <script type="module">
            app.component('v-notification-list',{
                template: '#v-notification-list-template',

                data() {
                    return {
                        notifications: [],

                        pagination: {},

                    }
                },

                mounted() {
                    this.getNotification();
                },

                methods: {
                    getNotification($event) {
                        const params = {};

                        if (this.status != 'all') {
                            params.status = this.status
                        }

                        this.$axios.get("{{ route('admin.notification.get_notification') }}", {
                            params: params
                        })
                        .then((response) => {
                            this.notifications = response.data.search_results.data;
                            this.pagination = response.data.search_results;
                        })
                        .catch(error => console.log(error));
                    },

                    getResults(page = 1) {
                        axios.get(`${"{{ route('admin.notification.get_notification') }}"}?page=${page}`)
                            .then(response => {
                                this.notifications = [];

                                this.notifications = response.data.search_results.data;

                                this.pagination = response.data.search_results;
                            });
                    }
                }
            })
        </script>
    @endPushOnce
</x-admin::layouts>