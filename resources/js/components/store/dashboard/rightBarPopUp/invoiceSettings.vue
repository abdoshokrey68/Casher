<template>
    <div id="edit-store-info" class="col-md-5 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="edit-store-info-header">
                <button
                    @click="invoicesettingsToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-receipt"></i> {{ lang.invoice_settings }}
                </h2>
            </div>
            <!-- End Edit Store Settings Header -->
            <div class="edit-store-info content p-2">
                <div>
                    <form
                        @submit.prevent="handleClick()"
                        @keydown="form.onKeydown($event)"
                        enctype="multipart/form-data"
                        role="form"
                        class="form-horizontal"
                    >
                        <div class="clear"></div>
                        <div class="auto-tax form-check form-switch">
                            <input
                                id="auto-tax"
                                v-model="form.autotax"
                                type="checkbox"
                                name="autotax"
                                class="form-check-input mt-2 mb-2"
                            />
                            <label
                                class="form-check-label p-1"
                                for="auto-tax"
                                >{{ lang.auto_tax }}</label
                            >
                            <div class="clear"></div>
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('autotax')"
                                v-html="form.errors.get('autotax')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="tax-record">
                            <label for="tax-record">
                                {{ lang.tax_record }} {{ lang.optional }}
                            </label>
                            <input
                                id="tax-record"
                                v-model="form.tax_record"
                                name="tax_record"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.tax_record"
                                min="0"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('tax_record')"
                                v-html="form.errors.get('tax_record')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="tax-card">
                            <label for="tax-card">
                                {{ lang.tax_card }} {{ lang.optional }}
                            </label>
                            <input
                                id="tax-card"
                                v-model="form.tax_card"
                                type="text"
                                name="tax_card"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.tax_card"
                                min="0"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('tax_card')"
                                v-html="form.errors.get('tax_card')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="file-no">
                            <label for="file-no">
                                {{ lang.file_no }} {{ lang.optional }}
                            </label>
                            <input
                                id="file-no"
                                v-model="form.file_no"
                                type="text"
                                name="file_no"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.file_no"
                                min="0"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('file_no')"
                                v-html="form.errors.get('file_no')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="invoice-tax">
                            <label for="invoice-tax">
                                {{ lang.tax_on_invoice }} {{ lang.optional }}
                            </label>
                            <input
                                id="invoice-tax"
                                v-model="form.tax"
                                type="number"
                                name="tax"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.tax_on_invoice"
                                min="0"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('tax')"
                                v-html="form.errors.get('tax')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="product_rtn">
                            <label for="product_rtn">
                                {{ lang.product_rtn }} {{ lang.optional }}
                            </label>
                            <input
                                id="product_rtn"
                                v-model="form.product_rtn"
                                type="text"
                                name="product_rtn"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.product_rtn"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('product_rtn')"
                                v-html="form.errors.get('product_rtn')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="message_ar">
                            <label for="message_ar">
                                {{ lang.message_ar }} {{ lang.optional }}
                            </label>
                            <textarea
                                id="message_ar"
                                v-model="form.message_ar"
                                type="text"
                                name="message_ar"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.invoice_message_ar"
                            >
                            </textarea>
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('message_ar')"
                                v-html="form.errors.get('message_ar')"
                            />
                            <small class="text-warning bold">
                                {{ lang.message_confirm }}
                            </small>
                        </div>

                        <div class="clear"></div>
                        <div class="message_en">
                            <label for="message_en">
                                {{ lang.message_en }} {{ lang.optional }}
                            </label>
                            <textarea
                                id="message_en"
                                v-model="form.message_en"
                                type="text"
                                name="message_en"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.invoice_message_en"
                            >
                            </textarea>
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('message_en')"
                                v-html="form.errors.get('message_en')"
                            />
                            <small class="text-warning bold">
                                {{ lang.message_confirm }}
                            </small>
                        </div>

                        <small class="text-primary bold">
                            {{ lang.invoice_mes_po }}
                        </small>
                        <div class="clear"></div>
                        <div class="float-end mt-3">
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
                                {{ lang.edit_info }}
                            </button>

                            <button
                                @click.prevent="invoicesettingsToggle()"
                                class="btn btn-light text-danger bold"
                            >
                                <i class="fas fa-times mt-2 ml-2"></i>
                                {{ lang.cancel }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
    name: "storeSettings",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            invoice: {},
            form: new Form({
                tax: 0,
                product_rtn: null,
                message_en: null,
                message_ar: null,
                store_id: null,
            }),
            locale: null,
            lang: this.$parent.lang,
        };
    },
    mounted() {
        this.getInvoiceSettings();
        this.locale = this.getLocale();
    },
    watch: {
        invoice: function () {
            this.form.autotax = this.invoice.autotax;
            this.form.tax_record = this.invoice.tax_record;
            this.form.tax_card = this.invoice.tax_card;
            this.form.file_no = this.invoice.file_no;
            this.form.tax = this.invoice.tax;
            this.form.product_rtn = this.invoice.product_rtn;
            this.form.message_en = this.invoice.message_en;
            this.form.message_ar = this.invoice.message_ar;
            this.form.store_id = this.store_id;
        },
    },
    methods: {
        invoicesettingsToggle: function () {
            this.$parent.invoicesettings = !this.$parent.invoicesettings;
        },
        async editInvoiceSettings() {
            const response = await this.form
                .post("/api/invoice/settings/edit")
                .then((res) => {
                    console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_modified
                    );
                    this.getInvoiceSettings();
                })
                .catch((err) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.please_check_the_data
                    );
                });
        },
        getInvoiceSettings: function () {
            axios
                .get(`/api/invoice/settings?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.invoice = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.please_check_the_data
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
        handleClick: function () {
            this.$confirm({
                auth: true,
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm, password) => {
                    if (confirm && password == "1234") {
                        this.editInvoiceSettings();
                    }
                },
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
