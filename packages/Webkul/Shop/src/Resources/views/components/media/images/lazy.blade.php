<v-shimmer-image {{ $attributes }}>
    <div {{ $attributes->merge(['class' => 'shimmer']) }}>
    </div>
</v-shimmer-image>

@pushOnce('scripts')
    <script type="text/x-template" id="v-shimmer-image-template">
        <div
            :id="'image-shimmer-' + $.uid"
            class="shimmer"
            v-bind="$attrs"
            v-show="isLoading"
        >
        </div>

        <img v-if="gallery"
             v-bind="$attrs"
             :data-src="src"
             :id="'image-' + $.uid"
             @load="onLoad"
             v-show="! isLoading"
             style="height: 500px; width: 500px"
        >
        <img v-else v-bind="$attrs"
             :data-src="src"
             :id="'image-' + $.uid"
             @load="onLoad"
             v-show="! isLoading"
        >

    </script>

    <script type="module">
        app.component('v-shimmer-image', {
            template: '#v-shimmer-image-template',

            props: ['src', 'gallery'],

            data() {
                return {
                    isLoading: true,
                };
            },

            mounted() {
                let self = this;

                let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = document.getElementById('image-' + self.$.uid);

                            lazyImage.src = lazyImage.dataset.src;

                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });

                lazyImageObserver.observe(document.getElementById('image-shimmer-' + this.$.uid));
            },

            methods: {
                onLoad() {
                    this.isLoading = false;
                },
            },
        });
    </script>
@endPushOnce
