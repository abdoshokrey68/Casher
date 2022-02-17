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
                    value="803.75"
                    disabled
                />

                <h2 class="text-center h4 bold m-2 p-3">
                    {{ lang.the_amount_paid }}
                </h2>
                <input
                    type="text"
                    name=""
                    id=""
                    class="form-control h5 border-primary"
                    placeholder="Enter the amount"
                />
                <h2 class="text-center h4 bold m-2 p-3">
                    {{ lang.remaining_amount }}
                </h2>
                <input
                    type="text"
                    class="form-control disabled bold text-center text-danger"
                    value="200.25"
                    disabled
                />
                <a
                    href="#"
                    @click="payinvoiceToggle()"
                    class="btn btn-warning h5 p-3 mt-3 text-center bold"
                >
                    <i class="fas fa-money-bill-wave"></i>
                    {{ lang.pay }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PayInvoice",
    components: {},
    data: function () {
        return {
            invoice_id: null,
            lang: this.$parent.lang,
        };
    },
    watch: {
        $route: function () {
            if (this.$route.query.invoice_id) {
                this.invoice_id = this.$route.query.invoice_id;
            }
        },
    },
    methods: {
        payinvoiceToggle: function () {
            this.$parent.payinvoice = !this.$parent.payinvoice;
        },
        getInvoiceDetails: function () {
            axios.get(`/api/invoicedetails=${this.invoice_id}`);
        },
    },
};
</script>
