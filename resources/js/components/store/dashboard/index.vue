<template>
    <div id="store-dashboard" class="store-dashboard">
        <div class="row">
            <div class="col-md-2 col-sm-12 p-0 h-100">
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
                    <navigation-bar> </navigation-bar>
                    <!-- End navigation bar -->
                </div>
                <!-- End Navigation Bar -->
                <div class="col-md-12 row">
                    <div class="col-md-5 p-0 card">
                        <invoice-details> </invoice-details>
                        <!-- End invoice details -->
                    </div>
                    <div class="col-md-5 p-0 card">
                        <products-section> </products-section>
                    </div>
                    <!-- End prodacts Section -->
                    <div class="col-md-2 p-0 card">
                        <store-sections> </store-sections>
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
                    class="new-invoice"
                    @click.self="newinvoice = !newinvoice"
                    v-if="newinvoice"
                >
                    <new-invoice> </new-invoice>
                </div>
                <!-- End Of New Invoice Component -->

                <div
                    id="pay-invoice"
                    class="pay-invoice"
                    @click.self="payinvoice = !payinvoice"
                    v-if="payinvoice"
                >
                    <pay-invoice> </pay-invoice>
                </div>
                <!-- End Of Pay Invoice Component -->

                <div
                    id="delete-invoice"
                    class="delete-invoice"
                    @click.self="deleteinvoice = !deleteinvoice"
                    v-if="deleteinvoice"
                >
                    <delete-invoice> </delete-invoice>
                </div>
                <!-- End Of Pay Invoice Component -->

                <div
                    id="edit-sections"
                    class="edit-sections"
                    @click.self="editsections = !editsections"
                    v-if="editsections"
                >
                    <edit-sections> </edit-sections>
                </div>
                <!-- End Of Edit Sections Component -->

                <div
                    id="edit-products"
                    class="edit-products"
                    @click.self="editproducts = !editproducts"
                    v-if="editproducts"
                >
                    <edit-products> </edit-products>
                </div>
                <!-- End Of Edit Products Component -->

                <div
                    id="daily-invoice"
                    class="daily-invoice"
                    @click.self="dailyinvoice = !dailyinvoice"
                    v-if="dailyinvoice"
                >
                    <daily-invoice> </daily-invoice>
                </div>
                <!-- End Of Edit Products Component -->

                <div
                    id="edit-members"
                    class="edit-members"
                    @click.self="editmembers = !editmembers"
                    v-if="editmembers"
                >
                    <edit-members> </edit-members>
                </div>
                <!-- End Of Edit Members Component -->

                <div
                    id="store-settings"
                    class="store-settings"
                    @click.self="storesettings = !storesettings"
                    v-if="storesettings"
                >
                    <store-settings> </store-settings>
                </div>
                <!-- End Of Edit Store Settings Component -->

                <div
                    id="edit-tables"
                    class="edit-tables"
                    @click.self="edittables = !edittables"
                    v-if="edittables"
                >
                    <edit-tables> </edit-tables>
                </div>
                <!-- End Of Edit Store Talbes Component -->

                <div
                    id="store-box"
                    class="store-box"
                    @click.self="storebox = !storebox"
                    v-if="storebox"
                >
                    <store-box> </store-box>
                </div>
                <!-- End Of Edit Store Talbes Component -->

                <div
                    id="store-box"
                    class="store-box"
                    @click.self="storehistory = !storehistory"
                    v-if="storehistory"
                >
                    <store-history> </store-history>
                </div>
                <!-- End Of Edit Store Talbes Component -->
            </div>
            <!-- End Of All POP UP Boxs -->
            <vue-confirm-dialog></vue-confirm-dialog>
            <!-- VUE CONFIRM DIALOAG COMPONENT -->
            <notifications group="dashboard" />
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
            storesettings: true,
            edittables: false,
            storebox: false,
            storehistory: false,
            time: "",
        };
    },
    mounted() {
        this.getStoreInfo();
        this.time = new Date().getTime();
        this.urlReplace();
    },
    watch: {
        $route: function () {
            // console.log(this.$route.query);
            // console.log(this.$route);
        },
    },
    methods: {
        getStoreInfo: function () {
            axios
                .get(`/api/storeinfo?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.storeINFO = res.data;
                })
                .catch((err) => console.log(err));
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
    },
};
</script>
