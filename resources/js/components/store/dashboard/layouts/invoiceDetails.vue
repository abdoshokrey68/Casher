<template>
    <div id="invoice-details" class="">
        <div class="col-md-12 p-1 bg-d-blue text-light">
            <h5 class="text-center p-2 m-0 bold">Invoice Details</h5>
        </div>
        <!-- End invoice details Header -->
        <div class="invoice-table invoice-details-table">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="text-center"
                        v-for="(details, index) in invoiceDetails.invoicedets"
                        :key="index"
                    >
                        <td>{{ details.name }}</td>
                        <td>{{ details.price }}</td>
                        <td>{{ details.quantity }}</td>
                        <td>
                            <span v-if="details.discount != 0">
                                {{ details.discount + "%" }}
                            </span>
                            <span v-else>--</span>
                        </td>
                        <td>{{ details.price * details.quantity }}</td>
                        <td class="bold">
                            <a href="#" @click="handleClick(details.id)">
                                <i class="fas fa-trash-alt btn btn-danger"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- End Invoice Table -->
        <div class="col-md-12 mt-5" v-if="invoice_id">
            <div class="border rounded col-md-12 mt-5">
                <h5 v-if="invoiceDetails.discount" class="bold p-3">
                    Total Before Discount
                    <span>
                        {{ invoiceDetails.total }}
                        <span class="text-danger">
                            {{ "× " + invoiceDetails.discount + "%" }}
                        </span>
                    </span>
                </h5>
                <h5 class="bold p-3">The Total Amount</h5>
                <input
                    type="text"
                    class="form-control disabled p-3 text-center bold bg-d-blue text-light"
                    :value="
                        invoiceDetails.invoiceTotal -
                        invoiceDetails.invoiceTotal *
                            (invoiceDetails.discount / 100)
                    "
                    disabled
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "invoiceDetails",
    data: function () {
        return {
            store_id: this.$parent.store_id,
            invoiceDetails: {},
            invoice_id: 0,
        };
    },
    watch: {
        $route: function () {
            if (
                this.$route.query.invoice_id &&
                this.$route.query.get_invoice_details
            ) {
                this.invoice_id = this.$route.query.invoice_id;
                this.getInvoiceDetails();
            }
        },
    },
    mounted() {},
    methods: {
        handleClick: function (details_id) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        this.deleteDetails(details_id);
                    }
                },
            });
        },
        getInvoiceDetails: function () {
            axios
                .get(`/api/invoicedetails?invoice_id=${this.invoice_id}`)
                .then((res) => {
                    console.log(res.data);
                    this.invoiceDetails = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteDetails: function (details_id) {
            axios
                .get(`/api/deletedetails?invoice_details_id=${details_id}`)
                .then((res) => {
                    console.log(res.data);
                    this.getInvoiceDetails();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
