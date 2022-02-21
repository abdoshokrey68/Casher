<template>
    <div id="daily-invoice" class="col-md-8 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="daily-invoice-header">
                <button
                    @click="dailyinvoiceToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.billing_details }}
                </h2>
            </div>
            <!-- End Daily Invoice Header -->
            <div class="daily-invoice content p-2">
                <div class="invoice-date mb-3 p-2 card">
                    <div class="row m-0">
                        <div class="col-md-6">
                            <label for="from-date" class="form-label">{{
                                lang.from
                            }}</label>
                            <input
                                type="date"
                                class="form-control"
                                id="from-date"
                                v-model="from"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="to-date" class="form-label"
                                >{{ lang.to }}
                            </label>
                            <input
                                type="date"
                                class="form-control"
                                id="to-date"
                                v-model="to"
                            />
                        </div>
                    </div>
                    <div class="clear"></div>
                    <small class="bold text-danger col-md-12">
                        {{ lang.date_style }} "DD-MM-YYYY"
                    </small>
                    <br />
                    <button
                        @click="getDailyInvoice()"
                        class="btn btn-primary float-end"
                    >
                        {{ lang.show_invoice }}
                    </button>
                </div>
                <!-- End Select Date Box  -->
                <div class="clear"></div>
                <!-- <div class="row export-to mt-2 mb-2">
                    <div class="col-md-4 mt-2">
                        <a
                            href="#"
                            class="btn btn-primary text-center bold col-12"
                        >
                            <i class="fas fa-print"></i>
                            Print
                        </a>
                    </div>
                    <div class="col-md-4 mt-2">
                        <a
                            href="#"
                            class="btn btn-danger text-center bold col-12"
                        >
                            <i class="fas fa-file-pdf"></i>
                            Export to PDF
                        </a>
                    </div>
                    <div class="col-md-4 mt-2">
                        <a
                            href="#"
                            class="btn btn-success text-center bold col-12"
                        >
                            <i class="fas fa-file-excel"></i>
                            Export to EXCEL
                        </a>
                    </div>
                </div> -->
                <!-- End Of Export To Box  -->
                <div class="all-invoices">
                    <div class="col-md-9 m-auto">
                        <h5
                            v-if="total != undefined"
                            class="h4 mt-2 text-center bold mt-5"
                        >
                            {{ lang.total_sales }}
                            <span id="total-salse" class="text-danger bold">
                                {{ total }}
                            </span>
                        </h5>
                    </div>
                    <div
                        style="max-height: 400px; overflow: auto"
                        class="curret-section-table"
                    >
                        <table
                            class="table table-hover table-striped table-dark"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">{{ lang.invoice_no }}</th>
                                    <th scope="col">{{ lang.total }}</th>
                                    <th scope="col">{{ lang.discount }}</th>
                                    <th scope="col">{{ lang.table_no }}</th>
                                    <th scope="col">{{ lang.date }}</th>
                                    <th scope="col">{{ lang.delete }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="text-center"
                                    v-for="(invoice, index) in invoices"
                                    :key="index"
                                >
                                    <td>{{ invoice.create_id }}</td>
                                    <td>{{ invoice.total }}</td>
                                    <td>{{ invoice.discount }}</td>
                                    <td>
                                        <span v-if="invoice.table_id">
                                            {{ invoice.table_id }}
                                        </span>
                                        <span v-else>N/A</span>
                                    </td>
                                    <td>{{ invoice.date }}</td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="handleClick(invoice.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt btn btn-danger"
                                            ></i
                                        ></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Button trigger modal -->
                        <!-- <button
                            type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#exampleModalCenter"
                        >
                            Launch demo modal
                        </button> -->

                        <!-- Modal -->
                        <!-- <div
                            class="modal fade"
                            id="exampleModalCenter"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true"
                        >
                            <div
                                class="modal-dialog modal-dialog-centered"
                                role="document"
                            >
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title"
                                            id="exampleModalLongTitle"
                                        >
                                            Modal title
                                        </h5>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true"
                                                >&times;</span
                                            >
                                        </button>
                                    </div>
                                    <div class="modal-body">...</div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-dismiss="modal"
                                        >
                                            Close
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                        >
                                            Save changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div v-if="invoices == null || invoices.length < 1">
                            <h4
                                class="h4 text-danger col-md-12 text-center bold"
                            >
                                {{ lang.no_invoice }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DailyInvoice",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            from: "0",
            to: "0",
            invoices: null,
            total: 0,
            lang: this.$parent.lang,
            locale: "",
        };
    },
    mounted() {
        // this.getDailyInvoice();
        this.getDate();
        this.locale = this.getLocale();
    },
    watch: {},
    methods: {
        dailyinvoiceToggle: function () {
            this.$parent.dailyinvoice = !this.$parent.dailyinvoice;
        },
        getDate: function () {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
            var yyyy = today.getFullYear();

            this.from = `${mm}-${dd}-${yyyy}`;
            this.to = `${mm}-${dd}-${yyyy}`;
        },
        getDailyInvoice: function () {
            axios
                .get(
                    `/api/dailyinvoice?store_id=${this.store_id}&getfrom=${this.from}&getto=${this.to}`
                )
                .then((res) => {
                    // console.log(res);
                    this.invoices = res.data.invoices;
                    this.total = res.data.invoicetotal;
                })
                .catch((err) => console.log(err));
        },
        deleteInvoice: function (invoice_id) {
            axios
                .get(`/api/deleteinvoice?invoice_id=${invoice_id}`)
                .then((res) => {
                    console.log(res);
                    this.getDailyInvoice();
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.delete_suucess
                    );
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.upaate_error
                    );
                });
        },
        handleClick: function (invoice_id) {
            this.$confirm({
                auth: true,
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm, password) => {
                    if (confirm && password == "1234") {
                        this.deleteInvoice(invoice_id);
                    }
                },
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
