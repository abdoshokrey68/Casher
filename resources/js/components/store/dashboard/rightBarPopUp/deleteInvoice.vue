<template>
    <div id="delete-invoice" class="col-md-4 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="delete-invoice-header">
                <button
                    @click="deleteInvoiceToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.delete_invoice }}
                </h2>
            </div>
            <!-- End delete invoice Header -->
            <div class="delete-invoice content p-2">
                <form action="#" class="p-2 bold mb-2">
                    <div class="form-group mt-2">
                        <label for="invoice-id">{{
                            lang.invoice_number
                        }}</label>
                        <input
                            type="number"
                            class="form-control mt-2"
                            id="invoice-id"
                            :placeholder="lang.invoice_number"
                            min="1"
                        />
                    </div>
                    <div class="form-btns mt-2 float-end">
                        <button
                            @click="handleClick()"
                            class="btn btn-danger mr-1 ml-1"
                        >
                            <i class="fas fa-trash-alt"></i> {{ lang.delete }}
                        </button>
                        <button
                            @click="deleteInvoiceToggle()"
                            class="btn text-secondary mr-1 ml-1 bold"
                        >
                            <i class="fas fa-times"></i>
                            {{ lang.cancel }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "deleteInvoice",
    components: {},
    data: function () {
        return {
            deleteinvoice: false,
        };
    },
    methods: {
        deleteInvoiceToggle: function () {
            this.$parent.deleteinvoice = !this.$parent.deleteinvoice;
        },
        handleClick() {
            this.$confirm({
                auth: true,
                message: `Only the manager has this authority`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 * @param {String} password
                 */
                callback: (confirm, password) => {
                    if (confirm && password == "1234") {
                        this.deleteInvoiceToggle();
                    }
                },
            });
        },
    },
};
</script>
