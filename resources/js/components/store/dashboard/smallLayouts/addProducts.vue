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
                    Add Product
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
                            Add Section
                        </button>

                        <button
                            @click.prevent="cancelMethod()"
                            class="btn btn-light text-danger bold"
                        >
                            <i class="fas fa-times mt-2 ml-2"></i> Cancel
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
            productquantity: 1,
            form: new Form({
                quantity: 1,
                invoice_id: 0,
                table_id: 0,
                product_id: this.product_id,
            }),
            count: 0,
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
                    this.$router.push(
                        this.$route.fullPath +
                            "&get_invoice_details=" +
                            this.count
                    );
                    this.count++;
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
