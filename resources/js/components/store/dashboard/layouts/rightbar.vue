<template>
    <div class="bg-d-blue col-md-12 p-0 h-100">
        <div class="col-md-12 pt-3 m-auto hover-zoom">
            <img
                v-if="store.image"
                :src="'/image/stores/image/' + store.image"
                alt="Store image"
                class="col-md-12 rounded-circle d-flex m-auto pt-3"
                style="width: 90%; height: 200px"
            />
            <img
                v-else
                src="/image/stores/image/store1.jpg"
                alt="Store image"
                class="col-md-12 rounded-circle d-flex m-auto pt-3"
                style="width: 90%; height: 200px"
            />
        </div>
        <!-- End Image Store -->

        <div class="store-info">
            <h1 id="store-name" class="text-center text-light p-2 h4 mt-2">
                {{ store.name }}
            </h1>
            <!-- <h6
                id="store-email"
                v-if="store.email"
                class="text-center text-light p-2 small m-0"
            >
                <i class="fas fa-envelope-open-text mr-1 ml-1"></i>
                {{ store.email }}
            </h6> -->

            <h6
                id="store-phone"
                v-if="store.phone"
                class="text-center text-light p-2 small m-0"
            >
                <i class="fas fa-headphones-alt mr-1 ml-1"></i>
                {{ store.phone }}
            </h6>
        </div>
        <!-- End Store Info -->

        <!-- End Orderd List -->
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "RightBar",
    props: ["store", "menu_link"],
    data: function () {
        return {
            store_id: this.$parent.store_id,
            invoice_id: null,
            invoice_btn: false,
            cash_system: false,
            lang: this.$parent.lang,
            position: {},
        };
    },
    watch: {
        $route: function () {
            this.cash_system = false;
            if (this.$route.query.invoice_id && this.$route.query.table_id) {
                this.invoice_id = parseInt(this.$route.query.invoice_id);
                let table_id = parseInt(this.$route.query.table_id);
                if (this.invoice_id != 0 && table_id == 0) {
                    this.invoice_btn = true; // If This is Cash system Undisplay Paid invoice btn && display new invoice btn
                    this.cash_system = true;
                } else {
                    this.cash_system = false;
                    if (this.invoice_id != 0) {
                        this.invoice_btn = true;
                    } else {
                        this.invoice_btn = false;
                    }
                }
            } else {
                this.invoice_btn = false;
            }
        },
    },
    mounted() {
        this.getPositions();
    },
    methods: {
        newInvoiceToggle: function () {
            this.$parent.newinvoice = !this.$parent.newinvoice;
        },
        payInvoiceToggle: function () {
            this.$parent.payinvoice = !this.$parent.payinvoice;
        },
        deleteInvoiceToggle: function () {
            this.$parent.deleteinvoice = !this.$parent.deleteinvoice;
        },
        editsectionsToggle: function () {
            this.$parent.editsections = !this.$parent.editsections;
        },
        editproductsToggle: function () {
            this.$parent.editproducts = !this.$parent.editproducts;
        },
        daliyinvoiceTogle: function () {
            this.$parent.dailyinvoice = !this.$parent.dailyinvoice;
        },
        editmembersToggle: function () {
            this.$parent.editmembers = !this.$parent.editmembers;
        },
        storeAudienceToggle: function () {
            this.$parent.storeaudience = !this.$parent.storeaudience;
        },
        storesettingsToggle: function () {
            this.$parent.storesettings = !this.$parent.storesettings;
        },
        invoiceSettingsToggle: function () {
            this.$parent.invoicesettings = !this.$parent.invoicesettings;
        },
        edittablesToggle: function () {
            this.$parent.edittables = !this.$parent.edittables;
        },
        storeBoxToggle: function () {
            this.$parent.storebox = !this.$parent.storebox;
        },
        storeHistoryToggle: function () {
            this.$parent.storehistory = !this.$parent.storehistory;
        },
        storeMenuToggle: function () {
            this.$parent.storemenu = !this.$parent.storemenu;
        },
        logout: function () {
            document.getElementById("logout-form").submit();
        },
        getPositions: function () {
            console.log("rightbar Test");
            axios
                .get(`/api/member/position?store_id=${this.store_id}`)
                .then((res) => {
                    console.log(res.data);
                    this.position = res.data.position;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
    },
};
</script>
