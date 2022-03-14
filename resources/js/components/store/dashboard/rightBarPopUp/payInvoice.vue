<template>
    <div id="pay-invoice" class="col-md-3 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="pay-invoice-header m-2">
                <button
                    @click="payinvoiceToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bold p-2 mt-2">
                    {{ lang.invoice_value }}
                </h2>
            </div>
            <div class="card pay-invoice-tabels m-2">
                <input
                    type="text"
                    class="form-control disabled bold text-center text-danger"
                    :value="getAmount()"
                    disabled
                />

                <form
                    @submit.prevent="paidinvoice()"
                    @keydown="form.onKeydown($event)"
                >
                    <h2 class="text-center h4 bold m-2 p-3">
                        <label for="paidamount">{{
                            lang.the_amount_paid
                        }}</label>
                    </h2>
                    <input
                        type="number"
                        step="0.01"
                        name="paidamount"
                        id="paidamount"
                        min="0"
                        required
                        autofocus
                        class="form-control h5 border-primary text-center"
                        v-model="paidamount"
                        placeholder="Enter the amount"
                    />
                    <div
                        class="text-danger bold"
                        v-if="form.errors.has('price')"
                        v-html="form.errors.get('price')"
                    />

                    <h2 class="text-center h4 bold m-2 p-3">
                        {{ lang.remaining_amount }}
                    </h2>
                    <input
                        type="text"
                        class="form-control disabled bold text-center text-danger"
                        v-model="remaining"
                        disabled
                        readonly="readonly"
                    />
                    <!-- <div id="invoice-print-area">
                        <print-invoice
                            :store_id="store_id"
                            :invoice_id="invoice_id"
                        ></print-invoice>
                    </div> -->
                    <div class="btns-controllers">
                        <button
                            type="submit"
                            class="btn btn-warning col-md-12 h5 p-3 mt-3 text-center bold"
                            :disabled="form.busy || pay_btn"
                        >
                            <span
                                class="spinner-border spinner-border-sm"
                                role="status"
                                :hidden="!form.busy"
                            ></span>
                            <span :hidden="form.busy">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ lang.pay }}
                            </span>
                        </button>
                        <!-- <button
                            class="btn btn-primary col-md-12 h5 p-3 mt-3 text-center bold"
                            @click.prevent="
                                printExternal(
                                    'http://localhost:8000/ar/store/6/invoice/print/285'
                                )
                            "
                        >
                            <i class="fas fa-print"></i>
                            {{ lang.invoice_printing }}
                        </button> -->
                        <button
                            @click.prevent="payinvoiceToggle()"
                            class="btn btn-light mt-2 col-md-12 text-danger bold"
                        >
                            <i class="fas fa-times mt-2 ml-2"></i>
                            {{ lang.cancel }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "PayInvoice",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            invoice_id: null,
            lang: this.$parent.lang,
            invoice: {},
            paidamount: null,
            remaining: 0.0,
            pay_btn: true,
            form: new Form({
                paidamount: 0.0,
                invoice_id: null,
                table_id: null,
                store_id: this.$parent.store_id,
            }),
            locale: null,
            invoice_printing: null,
        };
    },
    watch: {
        paidamount: function () {
            this.remaining = parseFloat(
                this.paidamount - this.getAmount()
            ).toFixed(2);
            this.form.paidamount = parseFloat(this.paidamount).toFixed(2);
            if (this.remaining >= 0.0) {
                this.pay_btn = false;
            } else {
                this.pay_btn = true;
            }
        },
    },
    mounted() {
        if (this.$route.query.invoice_id && this.$route.query.table_id) {
            this.invoice_id = parseInt(this.$route.query.invoice_id);
            this.getInvoiceDetails(this.invoice_id, this.store_id);
            this.form.invoice_id = this.invoice_id;
            this.form.table_id = parseInt(this.$route.query.table_id);
        } else {
            this.payinvoiceToggle();
        }
        this.locale = this.getLocale();
        var paidamount = document.getElementsByName("paidamount");
        paidamount[0].focus();
    },
    methods: {
        payinvoiceToggle: function () {
            this.$parent.payinvoice = !this.$parent.payinvoice;
        },
        getInvoiceDetails: function (invoice_id, store_id) {
            axios
                .get(
                    `/api/invoicedetails?invoice_id=${invoice_id}&store_id=${store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.invoice = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        async paidinvoice() {
            const response = await this.form
                .post("/api/payinvoice")
                .then((res) => {
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.Invoice_paid_successfully
                    );
                    this.urlReplace();
                    this.payinvoiceToggle();
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        printExternal: function (url) {
            var printWindow = window.open(
                url,
                "Print",
                "left=200, top=200, width=950, height=500, toolbar=0, resizable=0"
            );

            printWindow.addEventListener(
                "load",
                function () {
                    if (Boolean(printWindow.chrome)) {
                        this.setTimeout(function () {
                            printWindow.print();
                            // setTimeout(function () {
                            //     printWindow.close();
                            // }, 500);
                        }, 2000);
                    } else {
                        this.setTimeout(function () {
                            printWindow.print();
                            printWindow.close();
                        }, 2000);
                    }
                },
                true
            );
        },
        getAmount: function () {
            var amount =
                this.invoice.total -
                this.invoice.total * (this.invoice.discount / 100) +
                this.invoice.total * (this.invoice.tax / 100);
            return parseFloat(amount).toFixed(2);
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
        urlReplace: function () {
            if (this.$route.query) {
                this.$router
                    .replace({
                        path: this.$route.path,
                    })
                    .catch(() => {});
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
