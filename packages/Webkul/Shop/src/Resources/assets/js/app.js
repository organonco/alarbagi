/**
 * This will track all the images and fonts for publishing.
 */
import.meta.glob(["../images/**", "../fonts/**"]);

/**
 * Main vue bundler.
 */
import { createApp } from "vue/dist/vue.esm-bundler";

/**
 * We are defining all the global rules here and configuring
 * all the `vee-validate` settings.
 */
import { configure, defineRule, Field, Form, ErrorMessage } from "vee-validate";
import {localize, setLocale} from "@vee-validate/i18n";

import ar from "@vee-validate/i18n/dist/locale/ar.json";

import * as AllRules from '@vee-validate/rules';

/**
 * Registration of all global validators.
 */
Object.keys(AllRules).forEach(rule => {
    if (typeof AllRules[rule] === 'function') {
        defineRule(rule, AllRules[rule]);
    }
});
/**
 * This regular expression allows phone numbers with the following conditions:
 * - The phone number can start with an optional "+" sign.
 * - After the "+" sign, there should be one or more digits.
 *
 * This validation is sufficient for global-level phone number validation. If
 * someone wants to customize it, they can override this rule.
 */
defineRule("phone", (value) => {
    if (!value || !value.length) {
        return true;
    }

    if (!/^\+?\d+$/.test(value)) {
        return false;
    }

    return true;
});

defineRule("strong_password", (value) => {
	var strongRegex = new RegExp("^(?=.*[A-z])(?=.*[0-9])(?=.{8,})");
	return strongRegex.test(value);
});


configure({
    /**
     * Built-in error messages and custom error messages are available. Multiple
     * locales can be added in the same way.
     */
    generateMessage: localize({
        ar: {
            ...ar,
            messages: {
                ...ar.messages,
                phone: "{field} يجب أن يكون رقم هاتف صحيح",
				strong_password: "يجب أن تحتوي كلمة المرور على أحرف وأرقام"
            },
        },
    }),

    validateOnBlur: true,
    validateOnInput: true,
    validateOnChange: true,
});


setLocale(document.getElementsByTagName("html")[0].lang)

/**
 * Main root application registry.
 */
window.app = createApp({
    data() {
        return {};
    },

    mounted() {
        var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));

        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;

                    lazyImage.src = lazyImage.dataset.src;

                    lazyImage.classList.remove("lazy");

                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    },

    methods: {
        onSubmit() {},

        onInvalidSubmit() {},
    },
});

/**
 * Global plugins registration.
 */
import Axios from "./plugins/axios";
import Emitter from "./plugins/emitter";
import Shop from "./plugins/shop";

[Axios, Emitter, Shop].forEach((plugin) => app.use(plugin));

import Flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.css';
window.Flatpickr = Flatpickr;

/**
 * Global components registration;
 */
app.component("VForm", Form);
app.component("VField", Field);
app.component("VErrorMessage", ErrorMessage);

/**
 * Load event, the purpose of using the event is to mount the application
 * after all of our `Vue` components which is present in blade file have
 * been registered in the app. No matter what `app.mount()` should be
 * called in the last.
 */
window.addEventListener("load", function (event) {
    app.mount("#app");
});


import PullToRefresh from 'pulltorefreshjs';

const ptr = PullToRefresh.init({
	mainElement: '#app',
	onRefresh() {
	  window.location.reload();
	},
	instructionsPullToRefresh: "اسحب للتحديث",
	instructionsReleaseToRefresh: "أفلت للتحديث",
	instructionsRefreshing: "يتم تحديث المعلومات"
  });