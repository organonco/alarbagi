<v-mobile-category>
    <div>
    </div>
</v-mobile-category>

@pushOnce('scripts')
    <script type="text/x-template" id="v-mobile-category-template">
        <div class="gap-[10px] flex-wrap p-[10px] hidden max-lg:flex sn-background-light-main">
            <div class="w-full flex justify-between items-center mx-2">
                <a href="{{ route('shop.home.index') }}">
                    <img src="{{ core()->getCurrentChannel()->logo_url ?? asset('assets/images/logo.png') }}" alt="Logo"
                        width="160" height="29">
                </a>
                <a class="flex flex-col items-center py-2 badge_button"
                    href="{{ route('shop.checkout.cart.index') }}">
                    <img class="w-6 h-6"
                        src="{{ asset('assets/images/icons/cart-mobile.png') }}" />
                        <span class="badge" v-if="this.cart"></span>

                </a>
            </div>
            <form action="{{ route('shop.search.index') }}" class="flex items-center w-full">
                <label for="organic-search" class="sr-only">Search</label>
    
                <div class="relative w-full">
                    <div
                        class="icon-search flex items-center absolute left-[12px] top-[12px] text-[25px] pointer-events-none">
                    </div>
    
                    <input type="text"
                        class="block w-full px-11 py-3.5 border border-['#E3E3E3'] rounded-xl text-gray-900 text-xs font-medium"
                        name="query" value="{{ request('query') }}" placeholder="@lang('shop::app.components.layouts.header.search-text')" required>
                </div>
            </form>
        </div>
    </script>

    <script type="module">
        app.component('v-mobile-category', {
            template: '#v-mobile-category-template',

            data() {
                return {
                    categories: [],
                    cart: null,
                }
            },

            mounted() {
                this.get();
                this.getCart();
                this.$emitter.on('update-mini-cart', (cart) => {
                    this.cart = cart;
                });
            },

            methods: {
                getCart() {
                    this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                        .then(response => {
                            this.cart = response.data.data;
                            console.log(this.cart)
                        })
                        .catch(error => {});
                },

                get() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                toggle(selectedCategory) {
                    this.categories = this.categories.map((category) => ({
                        ...category,
                        isOpen: category.id === selectedCategory.id ? !category.isOpen : false,
                    }));
                },
            },
        });
    </script>
@endPushOnce
