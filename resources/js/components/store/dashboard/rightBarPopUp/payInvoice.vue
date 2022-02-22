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
                    :value="invoice.f_discount"
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

                    <div>
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
                            <i
                                class="fas fa-money-bill-wave"
                                :hidden="form.busy"
                            ></i>
                            {{ lang.pay }}
                        </button>

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
            invoice_id: null,
            lang: this.$parent.lang,
            invoice: {},
            paidamount: "",
            remaining: 0.0,
            pay_btn: true,
            form: new Form({
                paidamount: 0.0,
                invoice_id: null,
                table_id: null,
            }),
            locale: "",
            store_id: this.$parent.store_id,
        };
    },
    watch: {
        paidamount: function () {
            this.remaining = this.paidamount - this.invoice.f_discount;
            this.form.paidamount = parseInt(this.paidamount);
            if (this.remaining >= 0.0) {
                this.pay_btn = false;
            } else {
                this.pay_btn = true;
            }
        },
    },
    mounted() {
        if (this.$route.query.invoice_id) {
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
        console.log(paidamount);
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
                    console.log(err);
                });
        },
        async paidinvoice() {
            const response = await this.form
                .post("/api/payinvoice")
                .then((res) => {
                    // this.notification(
                    //     "success",
                    //     "Success",
                    //     "Section added successfully"
                    // );
                    this.urlReplace();
                    this.payinvoiceToggle();
                })
                .catch((err) => {
                    console.log(err);
                });
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
