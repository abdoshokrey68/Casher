<template>
    <div id="invoice-details" class="">
        <div class="col-md-12 p-1 bg-d-blue text-light">
            <h5 class="text-center p-3 m-0 bold">{{ lang.invo_det }}</h5>
        </div>
        <!-- End invoice details Header -->
        <div class="invoice-table invoice-details-table">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">{{ lang.name }}</th>
                        <th scope="col">{{ lang.price }}</th>
                        <th scope="col">{{ lang.qty }}</th>
                        <th scope="col">{{ lang.total }}</th>
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody v-if="invoiceDetails.invoicedets">
                    <tr
                        class="text-center"
                        v-for="(details, index) in invoiceDetails.invoicedets"
                        :key="index"
                    >
                        <td>{{ details.name }}</td>
                        <td>{{ details.price }}</td>
                        <td>{{ details.quantity }}</td>
                        <td>{{ details.price * details.quantity }}</td>
                        <td class="bold">
                            <a
                                href="#"
                                @click="handleClick(details.id, 'details')"
                            >
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
                <h6 v-if="invoiceDetails.discount" class="bold p-1 text-danger">
                    {{ lang.total_be_discount + "=" }}
                    <span>
                        {{ parseFloat(invoiceDetails.f_discount).toFixed(2) }}
                        <span class="">
                            {{ "× " + invoiceDetails.discount + "%" }}
                        </span>
                    </span>
                </h6>
                <h6 v-if="invoice_s.tax" class="bold p-1 text-danger">
                    {{ lang.tax }} =>
                    <span class="">{{ invoice_s.tax + "%" }}</span>
                </h6>
                <button
                    v-if="invoice_id != 0"
                    :class="getClass()"
                    @click="handleClick(invoice_id, 'invoice')"
                >
                    <i class="fas fa-xmark mr-2 ml-2 text-light"></i>
                    {{ lang.cancel_the_bill }}
                </button>
                <h5 class="bold p-2">{{ lang.total_amount }}</h5>
                <input
                    type="text"
                    class="form-control disabled p-3 text-center bold bg-d-blue text-light"
                    readonly="readonly"
                    :value="
                        getInvoiceValue(
                            invoiceDetails.f_discount,
                            invoiceDetails.discount,
                            invoice_s.tax
                        )
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
            lang: this.$parent.lang,
            invoice_s: {},
            locale: this.getLocale(),
        };
    },
    watch: {
        $route: function () {
            if (this.$route.query.invoice_id && this.$route.query.time) {
                this.invoice_id = this.$route.query.invoice_id;
                this.getInvoiceDetails();
                this.getInvoiceSettings(this.store_id);
            } else {
                this.invoiceDetails = {};
            }
        },
    },
    mounted() {
        // this.getInvoiceSettings(this.store_id);
    },
    methods: {
        handleClick: function (id, type) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        if (type == "details") {
                            this.deleteDetails(id, this.store_id);
                        } else {
                            this.deleteInvoice(this.invoice_id, this.store_id);
                        }
                    }
                },
            });
        },
        getInvoiceDetails: function () {
            axios
                .get(
                    `/api/invoicedetails?invoice_id=${this.invoice_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.invoiceDetails = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        getInvoiceSettings: function (store_id) {
            axios
                .get(`/api/invoice/settings?store_id=${store_id}`)
                .then((res) => {
                    // console.log(res);
                    this.invoice_s = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteDetails: function (details_id, store_id) {
            axios
                .get(
                    `/api/deletedetails?invoice_details_id=${details_id}&store_id=${store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.getInvoiceDetails();
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        deleteInvoice: function (invoice_id) {
            axios
                .get(
                    `/api/deleteinvoice?invoice_id=${invoice_id}&store_id=${this.store_id}&table_id=${this.invoiceDetails.table_id}`
                )
                .then((res) => {
                    // console.log(res);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.delete_suucess
                    );
                    this.urlReplace();
                    this.invoice_id = 0;
                    this.invoiceDetails = "empty";
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.upaate_error
                    );
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
        getInvoiceValue: function (total, discount, tax) {
            // if (this.invoiceDetails == "empty")
            //     console.log(this.invoiceDetails);
            if (this.invoiceDetails == "empty") {
                return 0;
            } else {
                return parseFloat(total + (total * tax) / 100).toFixed(2);
            }
        },
        getClass() {
            if (this.locale == "ar") {
                return "btn btn-danger text-light bold text-uppercase float-start";
            } else {
                return "btn btn-danger text-light bold text-uppercase float-end";
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
