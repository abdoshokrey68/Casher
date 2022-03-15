<template>
    <div id="store-box" class="col-md-3 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="store-box-header">
                <button
                    @click="storeBoxToggle()"
                    class="float-end btn btn-light"
                >
                    <i class="fas fa-times fa-2x"></i>
                </button>
            </div>
            <div v-if="!boxForm" class="col-md-12 p-2">
                <a
                    href="#"
                    :class="boxDelivery(form.status)"
                    @click="boxForm = !boxForm"
                >
                    {{ lang.treasury_delivery }}
                </a>
                <a
                    href="#"
                    :class="boxReceive(form.status)"
                    @click="boxForm = !boxForm"
                >
                    {{ lang.receipt_of_treasury }}
                </a>
            </div>
            <div>
                <form
                    class="col-md-12 p-2 mb-2"
                    v-if="boxForm"
                    @submit.prevent="handleClick()"
                    @keydown="form.onKeydown($event)"
                >
                    <div>
                        <label for="amount">
                            <i class="fas fa-money-bill-alt bold mr-2 ml-2"></i>
                            <span v-if="form.status == 0">
                                {{ lang.received_amount }}
                            </span>
                            <span v-else> {{ lang.the_amount_delivered }}</span>
                            " {{ username }} "
                        </label>
                        <input
                            v-model="form.amount"
                            type="number"
                            step="0.01"
                            name="amount"
                            id="amount"
                            min="0"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.whatsapp_number"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('amount')"
                            v-html="form.errors.get('amount')"
                        />
                    </div>

                    <div class="float-end mt-2 mb-2">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="form.busy"
                        >
                            <span
                                class="spinner-border spinner-border-sm"
                                role="status"
                                :hidden="!form.busy"
                            ></span>
                            <i
                                class="fas fa-plus mt-2 ml-2"
                                :hidden="form.busy"
                            ></i>
                            {{ lang.send_amount }}
                        </button>
                        <button
                            type="submit"
                            class="btn btn-light text-danger"
                            @click="boxForm = !boxForm"
                        >
                            <i class="fas fa-times mt-2 ml-2"></i>
                            {{ lang.cancel }}
                        </button>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
    name: "storeBox",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            box: {},
            username: null,
            boxForm: false,
            lang: this.$parent.lang,
            form: new Form({
                store_id: this.$parent.store_id,
                amount: 0,
                status: 0,
                password: null,
            }),
            locale: "",
            invoices: {},
        };
    },
    mounted() {
        this.locale = this.getLocale();
        this.getBoxInfo();
        this.getInvoices();
    },
    watch: {
        box: function () {
            if (this.box) this.form.status = this.box.status;
        },
    },
    methods: {
        storeBoxToggle: function () {
            this.$parent.storebox = !this.$parent.storebox;
        },
        async addToStoreBox() {
            const response = await this.form
                .post("/api/store/addtobox")
                .then((res) => {
                    this.invoiceNotPaid();
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_has_Sent
                    );
                    this.form.reset();
                    this.boxForm = !this.boxForm;
                    this.getBoxInfo();
                })
                .catch((err) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.went_wrong
                    );
                });
        },
        getBoxInfo: function () {
            axios
                .post(`/api/store/getboxinfo?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.box = res.data.box;
                    this.username = res.data.username;
                })
                .catch((err) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.went_wrong
                    );
                });
        },
        getInvoices: function () {
            axios
                .post(`/api/invoice/all/notpaid?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.invoices = res.data;
                    this.invoiceNotPaid();
                })
                .catch((err) => {});
        },
        notification: function (type, title, text) {
            this.$notify({
                group: "dashboard",
                speed: 1500,
                type: type, // error , warn, success
                title: title,
                text: text,
            });
        },
        handleClick: function () {
            this.$confirm({
                auth: true,
                message: `Enter Your Password`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm, password) => {
                    if (confirm) {
                        this.form.password = password;
                        this.addToStoreBox();
                    }
                },
            });
        },
        boxDelivery: function (status) {
            if (status == 1) {
                return "btn btn-primary col-md-12 p-2 mt-2";
            } else {
                return "btn btn-primary col-md-12 p-2 mt-2 disabled";
            }
        },
        invoiceNotPaid: function () {
            if (this.invoices) {
                this.invoices.forEach((invoice) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        `${this.lang.invoice_no} ${invoice.id} ${this.lang.not_paid} `
                    );
                });
            }
        },
        boxReceive: function (status) {
            if (status == 0) {
                return "btn btn-secondary col-md-12 p-2 mt-2";
            } else {
                return "btn btn-secondary col-md-12 p-2 mt-2 disabled";
            }
        },
        getType: function (type) {
            if (this.locale == "ar") {
                return `${type} text-end`;
            } else {
                return type;
            }
        },
    },
};
</script>
