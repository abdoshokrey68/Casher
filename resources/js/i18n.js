import Vue from 'vue';
// import ar from './lang/ar.json';
// import en from './lang/en.json';

// import {VueI18n} from 'vue-i18n';

// Vue.use(VueI18n);

// export default new VueI18n({
//     local: localStorage.getItem('lang') || en,
//     messages: {
//         ar:ar,
//         en:en
//     }
// })

import VueI18n from 'vue-i18n';
Vue.use(VueI18n)
const messages = {
    'en': {
        "hello": "hello",
    },
    'es': {
        "hello": "holla",
    }
};
const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'es', // set fallback locale
    messages, // set locale messages
});
