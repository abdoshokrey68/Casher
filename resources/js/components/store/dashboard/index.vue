<template>
    <div id="store-dashboard" class="store-dashboard">
        <div class="row">
            <div class="col-md-2 col-sm-12 p-0 right-bar-container">
                <right-bar
                    :store="storeINFO"
                    :logout="logout"
                    :menu_link="menu_link"
                >
                </right-bar>
            </div>
            <!-- End right bar -->
            <div class="col-md-10 p-0">
                <div>
                    <navigation-bar :store_id="store_id"> </navigation-bar>
                    <!-- End navigation bar -->
                </div>
                <!-- End Navigation Bar -->
                <div class="col-md-12 row">
                    <div class="col-md-5 p-0 card">
                        <invoice-details :store_id="store_id">
                        </invoice-details>
                        <!-- End invoice details -->
                    </div>
                    <div class="col-md-5 p-0 card">
                        <products-section :store_id="store_id">
                        </products-section>
                    </div>
                    <!-- End prodacts Section -->
                    <div class="col-md-2 p-0 card">
                        <store-sections :store_id="store_id"> </store-sections>
                        <!-- End store sections -->
                    </div>
                    <!-- End store sections -->
                </div>
                <!-- End Col-md-12 For Main Section -->
            </div>
            <!-- End right bar -->
            <div class="all-right-bar-popup">
                <div
                    id="new-invoice"
                    class="row new-invoice"
                    @click.self="newinvoice = !newinvoice"
                    v-if="newinvoice"
                >
                    <new-invoice :store_id="store_id"> </new-invoice>
                </div>
                <!-- End Of New Invoice Component -->

                <div
                    id="pay-invoice"
                    class="row pay-invoice"
                    @click.self="payinvoice = !payinvoice"
                    v-if="payinvoice"
                >
                    <pay-invoice :store_id="store_id"> </pay-invoice>
                </div>
                <!-- End Of Pay Invoice Component -->

                <div
                    id="delete-invoice"
                    class="row delete-invoice"
                    @click.self="deleteinvoice = !deleteinvoice"
                    v-if="deleteinvoice"
                >
                    <delete-invoice :store_id="store_id"> </delete-invoice>
                </div>
                <!-- End Of Pay Invoice Component -->

                <div
                    id="edit-sections"
                    class="row edit-sections"
                    @click.self="editsections = !editsections"
                    v-if="editsections"
                >
                    <edit-sections :store_id="store_id"> </edit-sections>
                </div>
                <!-- End Of Edit Sections Component -->

                <div
                    id="edit-products"
                    class="row edit-products"
                    @click.self="editproducts = !editproducts"
                    v-if="editproducts"
                >
                    <edit-products :store_id="store_id"> </edit-products>
                </div>
                <!-- End Of Edit Products Component -->

                <div
                    id="daily-invoice"
                    class="row daily-invoice"
                    @click.self="dailyinvoice = !dailyinvoice"
                    v-if="dailyinvoice"
                >
                    <daily-invoice :store_id="store_id"> </daily-invoice>
                </div>
                <!-- End Of Edit Products Component -->

                <div
                    id="edit-members"
                    class="row edit-members"
                    @click.self="editmembers = !editmembers"
                    v-if="editmembers"
                >
                    <edit-members :store_id="store_id"> </edit-members>
                </div>
                <!-- End Of Edit Members Component -->

                <div
                    id="store-audience"
                    class="row store-audience"
                    @click.self="storeaudience = !storeaudience"
                    v-if="storeaudience"
                >
                    <store-audience :store_id="store_id"> </store-audience>
                </div>
                <!-- End Of Edit Members Component -->

                <div
                    id="store-settings"
                    class="row store-settings"
                    @click.self="storesettings = !storesettings"
                    v-if="storesettings"
                >
                    <store-settings :store_id="store_id"> </store-settings>
                </div>
                <!-- End Of Edit Store Settings Component -->

                <div
                    id="invoice-settings"
                    class="row invoice-settings"
                    @click.self="invoicesettings = !invoicesettings"
                    v-if="invoicesettings"
                >
                    <invoice-settings :store_id="store_id"> </invoice-settings>
                </div>
                <!-- End Of Edit Store Settings Component -->

                <div
                    id="edit-tables"
                    class="row edit-tables"
                    @click.self="edittables = !edittables"
                    v-if="edittables"
                >
                    <edit-tables :store_id="store_id"> </edit-tables>
                </div>
                <!-- End Of Edit Store Talbes Component -->

                <div
                    id="store-box"
                    class="row store-box"
                    @click.self="storebox = !storebox"
                    v-if="storebox"
                >
                    <store-box :store_id="store_id"> </store-box>
                </div>
                <!-- End Of Edit Store Box Component -->

                <div
                    id="store-history"
                    class="row store-history"
                    @click.self="storehistory = !storehistory"
                    v-if="storehistory"
                >
                    <store-history :store_id="store_id"> </store-history>
                </div>
                <!-- End Of Edit Store History Component -->

                <div
                    id="store-menu"
                    class="row store-menu"
                    @click.self="storemenu = !storemenu"
                    v-if="storemenu"
                >
                    <edit-menu :store_id="store_id"> </edit-menu>
                </div>
                <!-- End Of Edit Store Menu Component -->
            </div>
            <!-- End Of All POP UP Boxs -->
            <vue-confirm-dialog></vue-confirm-dialog>
            <!-- VUE CONFIRM DIALOAG COMPONENT -->
            <notifications :class="getTextAlign()" group="dashboard" />
            <!-- VUE NOTIFICATION COMPONENT -->
        </div>
    </div>
</template>

<script>
export default {
    name: "storeDashboard",
    props: ["logout", "store_id", "menu_link"],
    data: function () {
        return {
            storeINFO: {},
            newinvoice: false,
            payinvoice: false,
            deleteinvoice: false,
            editsections: false,
            editproducts: false,
            dailyinvoice: false,
            editmembers: false,
            storesettings: false,
            invoicesettings: false,
            edittables: false,
            storebox: false,
            storehistory: false,
            storemenu: false,
            storeaudience: false,
            time: "",
            locale: "",
            lang: this.getLang(),
            position: {},
        };
    },
    mounted() {
        this.getStoreInfo(this.store_id);
        this.time = new Date().getTime();
        this.urlReplace();
        this.getPositions();
    },
    watch: {},
    methods: {
        getStoreInfo: function (store_id) {
            axios
                .get(`/api/storeinfo?store_id=${store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.storeINFO = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        getPositions: function () {
            axios
                .get(`/api/member/position?store_id=${this.store_id}`)
                .then((res) => {
                    this.position = res.data.position;
                })
                .catch((err) => {});
        },
        urlReplace: function () {
            if (this.$route.query) {
                this.$router
                    .replace({
                        path: this.$route.path,
                    })
                    .catch(() => {});
            }
        },
        getTextAlign: function () {
            var locale = this.getLocale();
            // console.log(locale);
            if (locale == "ar") return "text-right";
            else return "text-left";
        },
    },
};
</script>
