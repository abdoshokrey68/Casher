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
                            @click.prevent="cancelMethod()"
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
export default {
    name: "addProduct",
    props: ["product_id"],
    data: function () {
        return {
            product: {},
            store_id: this.$parent.store_id,
            productquantity: 1,
            form: new Form({
                quantity: 1,
                invoice_id: 0,
                table_id: 0,
                product_id: this.product_id,
            }),
            lang: this.$parent.lang,
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
                "error",
                "Error Message",
                "Select the table or type of payment first"
            );
        }
        this.time = new Date().getTime();
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
                    console.log(res.data);
                    // if (this.$route.query.get_invoice_details) {
                    //     var l_g_i_d =
                    //         this.$route.query.get_invoice_details.Number() + 1; // Latest get invoice details
                    //     console.log(
                    //         this.$route.query.get_invoice_details.Number()
                    //     );
                    // } else {
                    //     var l_g_i_d = 0;
                    // }
                    console.log(this.$route.query);
                    var url = this.$route.query;
                    delete url.invoice_id;
                    console.log(this.$route.query);
                    console.log(url);

                    this.$router.replace(
                        this.$route.fullPath +
                            "&get_invoice_details=" +
                            this.time
                    );

                    console.log(this.$route.query.get_invoice_details);
                    // this.$router.push({
                    //     path: `store/${this.store_id}`,
                    //     query: { get_invoice_details: this.time },
                    // });

                    console.log(this.$route.query);
                    // this.$router.push({
                    //     params: { get_invoice_details: "this.time" },
                    // });
                    this.time = new Date().getTime();
                    this.form.reset();
                    this.$parent.addProductsComponent =
                        !this.$parent.addProductsComponent;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getProductDetails: function () {
            axios
                .get(`/api/productdetails?product_id=${this.product_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.product = res.data;
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
        addProductToInvoice: function (product_id) {
            axios
                .get(`/api/addproducttoinvoice?product_id=${product_id}`)
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        cancelMethod: function () {},
    },
};
</script>
