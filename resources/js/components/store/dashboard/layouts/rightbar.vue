<template>
    <div class="bg-d-blue col-md-12 p-0">
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

            <!-- <h6
                id="store-phone"
                v-if="store.phone"
                class="text-center text-light p-2 small m-0"
            >
                <i class="fas fa-headphones-alt mr-1 ml-1"></i>
                {{ store.phone }}
            </h6> -->
        </div>
        <!-- End Store Info -->

        <div class="list-group p-2">
            <button
                @click="newInvoiceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-plus mr-2 ml-2"></i>
                New Invoice
            </button>
            <button
                @click="payInvoiceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
                :disabled="!invoice_id || invoice_id != 0"
            >
                <i class="fas fa-money-bill-wave mr-2 ml-2"></i>
                Pay The Amount
            </button>
            <!-- <button
                @click="deleteInvoiceToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                Delete Invoice
            </button> -->
            <button
                @click="editsectionsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-list mr-2 ml-2"></i>
                Edit Sections
            </button>
            <button
                @click="editproductsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cookie-bite mr-2 ml-2"></i>
                Edit Products
            </button>
            <button
                @click="daliyinvoiceTogle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-file-alt mr-2 ml-2"></i>
                Daily Invoices
            </button>
            <button
                @click="editmembersToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-users-cog mr-2 ml-2"></i>
                Edit Members
            </button>
            <button
                @click="storesettingsToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-store mr-2 ml-2"></i>
                Store Settings
            </button>
            <button
                @click="edittablesToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cogs mr-2 ml-2"></i>

                Table Management
            </button>
            <button
                @click="storeBoxToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-cash-register mr-2 ml-2"></i>
                Box
            </button>
            <button
                @click="storeHistoryToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-history mr-2 ml-2"></i>
                Store History
            </button>
            <button
                @click="storeMenuToggle()"
                class="list-group-item list-group-item-action text-center mb-2 action"
            >
                <i class="fas fa-concierge-bell mr-2 ml-2"></i>
                Store Menu
            </button>
            <a
                :href="menu_link"
                class="list-group-item list-group-item-action text-center mb-2 action"
                target="_blank"
            >
                <i class="fas fa-concierge-bell mr-2 ml-2"></i>
                Open Menu
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
                Sign out
            </button>
        </div>
        <!-- End Orderd List -->
    </div>
</template>

<script>
export default {
    name: "RightBar",
    props: ["store", "menu_link"],
    data: function () {
        return {
            invoice_id: null,
        };
    },
    watch: {
        $route: function () {
            if (
                this.$route.query.invoice_id &&
                this.$route.query.table_id &&
                !this.$route.query.table_id
            )
                this.invoice_id = this.$route.query.invoice_id;
            // else this.invoice_id = null;
        },
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
        storesettingsToggle: function () {
            this.$parent.storesettings = !this.$parent.storesettings;
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
    },
};
</script>
