@props(['options'])

<v-carousel-mobile>
    <div class="shimmer w-full aspect-[2.5/1]">
    </div>
</v-carousel-mobile>

@pushOnce('scripts')
    <script type="text/x-template" id="v-carousel-mobile-template">
        <div class="w-full relative m-auto aspect-[2.5/1]">
            <a
                v-for="(image, index) in images"
                class="fade"
                :href="image.link || '#'"
                ref="slides"
                :key="index"
                aria-label="Image Slide "
            >
                <x-shop::media.images.lazy
                    class="w-full"
                    ::src="image.image"
                    alt=""
                ></x-shop::media.images.lazy>
            </a>

            <span
                style="position: absolute; top: 0; left: 0; width: 50%; height: 100%"
                v-if="images?.length >= 2"
                @click="navigate(currentIndex -= 1)"
            >
            </span>

            <span
                style="position: absolute; top: 0; left: 50%; width: 50%; height: 100%"
                v-if="images?.length >= 2"
                @click="navigate(currentIndex += 1)"
            >
            </span>
        </div>
    </script>

    <script type="module">
        app.component("v-carousel-mobile", {
            template: '#v-carousel-mobile-template',

            data() {
                return {
                    currentIndex: 1,

                    images: @json($options['images'] ?? []),
                };
            },

            mounted() {
                this.navigate(this.currentIndex);

                this.play();
            },

            methods: {
                navigate(index) {
                    if (index > this.images.length) {
                        this.currentIndex = 1;
                    }

                    if (index < 1) {
                        this.currentIndex = this.images.length;
                    }

                    let slides = this.$refs.slides;

                    for (let i = 0; i < slides.length; i++) {
                        if (i == this.currentIndex - 1) {
                            continue;
                        }

                        slides[i].style.display = 'none';
                    }

                    slides[this.currentIndex - 1].style.display = 'block';
                },

                play() {
                    let self = this;

                    setInterval(() => {
                        this.navigate(this.currentIndex += 1);
                    }, 5000);
                }
            }
        });
    </script>

    <style>
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }
    </style>
@endpushOnce
