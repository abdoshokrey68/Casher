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

        <div class="list-group p-2">
            <div v-if="!this.cash_system">
                <button
                    v-if="position.invoice_add"
                    @click="newInvoiceToggle()"
                    class="list-group-item list-group-item-action text-center mb-2 action"
                >
                    <i class="fas fa-plus mr-2 ml-2"></i>
                    {{ lang.new_invoice }}
                </button>
            </div>
            <button
                v-if="position.invoice_add"
                @click="payInvoiceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
                :disabled="!invoice_btn"
            >
                <i class="fas fa-money-bill-wave mr-2 ml-2"></i>
                {{ lang.pay_the_amount }}
            </button>
            <!-- <button
                @click="deleteInvoiceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                Delete Invoice
            </button> -->
            <button
                v-if="
                    position.section_show ||
                    position.section_add ||
                    position.section_edit ||
                    position.section_delete
                "
                @click="editsectionsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-list mr-2 ml-2"></i>
                {{ lang.edit_sections }}
            </button>
            <button
                v-if="
                    position.product_show ||
                    position.product_add ||
                    position.product_edit ||
                    position.product_delete
                "
                @click="editproductsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cookie-bite mr-2 ml-2"></i>
                {{ lang.edit_products }}
            </button>
            <button
                v-if="position.invoice_show"
                @click="daliyinvoiceTogle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-file-alt mr-2 ml-2"></i>
                {{ lang.daily_invoice }}
            </button>
            <button
                v-if="
                    position.member_show ||
                    position.member_add ||
                    position.member_edit ||
                    position.member_delete
                "
                @click="editmembersToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-users-cog mr-2 ml-2"></i>
                {{ lang.edit_members }}
            </button>
            <button
                @click="storeAudienceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-users mr-2 ml-2"></i>
                {{ lang.store_audience }}
            </button>
            <button
                v-if="position.store_show || position.store_edit"
                @click="storesettingsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-store mr-2 ml-2"></i>
                {{ lang.store_settings }}
            </button>
            <button
                v-if="position.invoice_edit"
                @click="invoiceSettingsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-receipt mr-2 ml-2"></i>
                {{ lang.invoice_settings }}
            </button>
            <button
                v-if="
                    position.table_show ||
                    position.table_add ||
                    position.table_edit ||
                    position.table_delete
                "
                @click="edittablesToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cogs mr-2 ml-2"></i>

                {{ lang.table_manage }}
            </button>
            <button
                v-if="position.box_add"
                @click="storeBoxToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cash-register mr-2 ml-2"></i>
                {{ lang.box }}
            </button>
            <button
                v-if="position.history_show"
                @click="storeHistoryToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-shield mr-2 ml-2"></i>
                {{ lang.dark_box }}
            </button>
            <button
                v-if="position.menu_edit"
                @click="storeMenuToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-concierge-bell mr-2 ml-2"></i>
                {{ lang.store_menu }}
            </button>
            <a
                :href="menu_link"
                class="list-group-item list-group-item-action text-center mb-2 action"
                target="_blank"
            >
                <i class="fas fa-up-right-from-square mr-2 ml-2"></i>
                {{ lang.open_menu }}
            </a>
            <!-- <a :href="logout" @click.prevent="logout()"> Logout </a>

            <form
                id="logout-form"
                :action="logout"
                method="POST"
                class="d-none"
            >
                @csrf
            </form> -->
            <button
                class="list-group-item list-group-item-action bg-danger text-light bold text-center mb-2 action"
            >
                <i class="fas fa-sign-out-alt"></i>
                {{ lang.logout }}
            </button>
        </div>
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
            axios
                .post(`api/member/position?store_id=${this.store_id}`, {
                    headers: {
                        // remove headers
                    },
                })
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
