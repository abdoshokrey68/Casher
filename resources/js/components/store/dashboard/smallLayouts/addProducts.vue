<template>
    <div id="add-product" class="col-md-3 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-invoice-header">
                <button
                    @click="addProductsToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.add_product }}
                </h2>
            </div>
            <!-- End Add Prodact Header -->
            <div class="p-2">
                <form
                    @submit.prevent="addToDetails()"
                    @keydown="form.onKeydown($event)"
                >
                    <input
                        v-model="form.quantity"
                        type="number"
                        name="quantity"
                        class="form-control mt-2 mb-2"
                        placeholder="Product Name"
                    />
                    <div
                        class="text-danger bold"
                        v-if="form.errors.has('quantity')"
                        v-html="form.errors.get('quantity')"
                    />

                    <div class="float-end">
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
                            {{ lang.add_product }}
                        </button>

                        <button
                            @click.prevent="addProductsToggle()"
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
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
    name: "addProduct",
    props: ["product_id"],
    data: function () {
        return {
            product: {},
            store_id: this.$parent.store_id,
            productquantity: 1,
            invoice_id: 55,
            form: new Form({
                quantity: 1,
                invoice_id: 0,
                table_id: 0,
                product_id: this.product_id,
            }),
            lang: this.$parent.lang,
            time: 0,
            locale: "",
        };
    },
    mounted() {
        this.getProductDetails();
        if (this.$route.query.invoice_id) {
            this.form.invoice_id = parseInt(this.$route.query.invoice_id);
            this.form.table_id = parseInt(this.$route.query.table_id);
        } else {
            this.$parent.addProductsComponent =
                !this.$parent.addProductsComponent;
            this.notification(
                this.getType("error"),
                this.lang.error,
                this.lang.select_the_table
            );
        }
        this.time = new Date().getTime();
        this.locale = this.getLocale();
    },
    methods: {
        addProductsToggle() {
            this.$parent.addProductsComponent =
                !this.$parent.addProductsComponent;
            this.$parent.addproduct_id = null;
        },
        async addToDetails() {
            const response = await this.form
                .post("/api/addtodetails")
                .then((res) => {
                    this.invoice_id = res.data.invoice_id;
                    // console.log(res.data);
                    this.updateUrl(this.invoice_id);

                    // this.$router.replace(
                    //     this.$route.fullPath +
                    //         "&get_invoice_details=" +
                    //         this.time
                    // );

                    this.time = new Date().getTime();
                    this.form.reset();
                    this.$parent.addProductsComponent =
                        !this.$parent.addProductsComponent;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        getProductDetails: function () {
            axios
                .get(
                    `/api/productdetails?product_id=${this.product_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.product = res.data;
                })
                .catch((err) => {
                    // console.log(err);
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
        addProductToInvoice: function (product_id) {
            axios
                .get(
                    `/api/addproducttoinvoice?product_id=${product_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    // console.log(res);
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        updateUrl: function (invoice_id) {
            this.$router
                .push({
                    path: this.$route.path,
                    query: {
                        table_id: this.$route.query.table_id,
                        invoice_id: invoice_id,
                        section: this.$route.query.section_id,
                        time: this.$route.query.time,
                        get_invoice_details: this.time,
                    },
                })
                .catch(() => {});
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
