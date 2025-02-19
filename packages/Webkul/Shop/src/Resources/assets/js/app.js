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
import { localize, setLocale } from "@vee-validate/i18n";

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

        let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;

                    lazyImage.src = lazyImage.dataset.src;

                    lazyImage.classList.remove("lazy");

                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    },

    methods: {
        onSubmit() { },

        onInvalidSubmit() { },
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

import { Loader } from 'google-maps';

const options = { libraries: ['places'], language: "ar" };
const loader = new Loader('AIzaSyA2mtyhq14pKHoTX0JMCqyTd1oxVrnr3fE', options);

window.loader = loader;


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

if (!window.location.href.includes("checkout/onepage") && !window.location.href.includes("customer/account/addresses"))
    PullToRefresh.init({
        mainElement: '#app',
        onRefresh() {
            window.location.reload();
        },
        instructionsPullToRefresh: "اسحب للتحديث",
        instructionsReleaseToRefresh: "أفلت للتحديث",
        instructionsRefreshing: "يتم تحديث المعلومات"
    });


// Notifications Setup

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

const firebaseConfig = {
    apiKey: "AIzaSyCuu5HyjJ0zPma-jwvxlLcNrhrpubyftMk",
    authDomain: "alarbagi-8c44a.firebaseapp.com",
    databaseURL: "https://alarbagi-8c44a-default-rtdb.europe-west1.firebasedatabase.app",
    projectId: "alarbagi-8c44a",
    storageBucket: "alarbagi-8c44a.firebasestorage.app",
    messagingSenderId: "524130844148",
    appId: "1:524130844148:web:3597ca019ef052a6934da1"
};

const firebaseApp = initializeApp(firebaseConfig);

const messaging = getMessaging(firebaseApp);

async function requestPermission() {
    try {
        const permission = await Notification.requestPermission();
        return permission === 'granted';
    } catch (error) {
        return false;
    }
}

async function getTokenFromFirebase() {
    const hasPermission = await requestPermission();

    if (!hasPermission) {
        return null;
    }

    try {
        const token = await getToken(messaging, { vapidKey: 'BHuh506I50KIAEO4_JD_r7BNeSdz-oVHUQ0CuqWT_WW8Fe-fxZEVeIMecCmd4dzaUKYF1NmEyFvTdUJvTX5Evl4' });
        await sendTokenToServer(token);
        return token;
    } catch (error) {
        console.error('Error getting FCM token:', error);
        if (error.code === 'messaging/permission-blocked') {
            console.log('Notification permission blocked.');
        } else if (error.code === 'messaging/unsupported-browser') {
            console.log('This browser does not support notifications.');
        }
        return null;
    }
}


onMessage(messaging, (payload) => {
    new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon,
    });
});


async function sendTokenToServer(token) {
    axios.post('/fcm', {token: token});
}

getTokenFromFirebase();
