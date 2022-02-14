import Vue from 'vue';
import ar from './lang/ar.json';
import en from './lang/en.json';

import {VueI18n} from 'vue-i18n';

Vue.use(VueI18n);

export default new VueI18n({
    local: localStorage.getItem('lang') || en,
    messages: {
        ar:ar,
        en:en
    }
})
