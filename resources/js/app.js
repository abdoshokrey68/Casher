require('./bootstrap');

window.Vue = require('vue').default;

import VueConfirmDialog from 'vue-confirm-dialog'
import Form from 'vform';

import Vue           from 'vue';
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

// ===================== IMPORT SMALL LAYOUTS  ======================


// ===================== Main Store pages ======================
Vue.component('dashboard-store', require('./components/store/dashboard/index.vue').default);
Vue.component('store-menu', require('./components/store/menu/index.vue').default);


import router from './routes/routes.js';

const app = new Vue({
    el: '#app',
    router
});
