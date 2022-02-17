require('./bootstrap');

import Vue from 'vue'
window.Vue = require('vue').default;

import VueConfirmDialog from 'vue-confirm-dialog'
import Form from 'vform';
import axios from 'axios';


// import i18n from './i18n.js';

// Vue.config.productionTip = false;


// =====================================
// ========= Set Language Settings =====
// =====================================
// localStorage.setItem('lang', 'ar');
// window.location.reload();

const lang = localStorage.getItem('lang') || 'ar';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.headers['Accept-Language'] = "ar";

import Notifications from 'vue-notification';
Vue.use(Notifications)

Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

// ===================== Store Dashboard Layouts ======================
Vue.component('navigation-bar', require('./components/store/dashboard/layouts/navigationbar.vue').default);
Vue.component('right-bar', require('./components/store/dashboard/layouts/rightbar.vue').default);
Vue.component('store-sections', require('./components/store/dashboard/layouts/storeSections.vue').default);
Vue.component('invoice-details', require('./components/store/dashboard/layouts/invoiceDetails.vue').default);
Vue.component('products-section', require('./components/store/dashboard/layouts/productsSection.vue').default);


// ===================== Store Right Bar POP UP ======================

Vue.component('new-invoice', require('./components/store/dashboard/rightBarPopUp/newInvoice.vue').default);
Vue.component('pay-invoice', require('./components/store/dashboard/rightBarPopUp/payInvoice.vue').default);
Vue.component('delete-invoice', require('./components/store/dashboard/rightBarPopUp/deleteInvoice.vue').default);
Vue.component('edit-sections', require('./components/store/dashboard/rightBarPopUp/editSections.vue').default);
Vue.component('edit-products', require('./components/store/dashboard/rightBarPopUp/editProducts.vue').default);
Vue.component('daily-invoice', require('./components/store/dashboard/rightBarPopUp/dailyInvoice.vue').default);
Vue.component('edit-members', require('./components/store/dashboard/rightBarPopUp/editMembers.vue').default);
Vue.component('store-settings', require('./components/store/dashboard/rightBarPopUp/storeSettings.vue').default);
Vue.component('edit-tables', require('./components/store/dashboard/rightBarPopUp/editTables.vue').default);
Vue.component('store-box', require('./components/store/dashboard/rightBarPopUp/storeBox.vue').default);
Vue.component('store-history', require('./components/store/dashboard/rightBarPopUp/storeHistory.vue').default);
Vue.component('edit-menu', require('./components/store/dashboard/rightBarPopUp/storeMenu.vue').default);

// ===================== IMPORT SMALL LAYOUTS  ======================


// ===================== Store Compoentn ======================
Vue.component('dashboard-store', require('./components/store/dashboard/index.vue').default);
Vue.component('store-menu', require('./components/store/menu/index.vue').default);
Vue.component('main-footer', require('./components/store/layouts/mainFooter.vue').default);

// ============================================================
// ===================== Home Components ======================
// ============================================================

Vue.component('home-component', require('./components/home/homeComponent.vue').default);
Vue.component('create-store', require('./components/home/createStore.vue').default);
Vue.component('casher-program', require('./components/home/casherProgram.vue').default);

import router from './routes/routes.js';
import ar from './lang/ar.json';
import en from './lang/en.json';

// const def_lang = localStorage.getItem('lang');
var def_lang = localStorage.getItem('lang');
Vue.prototype.getLocale = function getLocale() {
    if (length == 1) {
        this.lang = this.getLang("en");
    } else {
        this.lang = this.getLang("ar");
    }
}
Vue.prototype.getLang = function getLang(lang = def_lang) {
    var url = this.$route.path.split("/");
    var filter = url.filter((e) => e == "en");
    var length = url.filter((e) => e == "en").length;
    if (length == 1) {
        return en;
    } else {
        return ar;
    }
}
const app = new Vue({
    el: '#app',
    router,
    // i18n,
    mounted() {
    }
});
