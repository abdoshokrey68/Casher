<template>
    <div id="edit-products" class="col-md-8 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="edit-products-header">
                <button
                    @click="editproductsToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    Prodacts Control
                </h2>
            </div>
            <!-- End Edit Product Header -->
            <div class="edit-products content p-2">
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
                <!-- End Of " Export To "   -->

                <div class="add-new-product mt-2 mb-2 card p-2">
                    <button
                        v-if="!addProductForm"
                        @click="addProductForm = !addProductForm"
                        class="btn btn-dark text-center mb-2"
                    >
                        Add New Product
                    </button>

                    <form
                        @submit.prevent="getFormMethod()"
                        @keydown="form.onKeydown($event)"
                        v-if="addProductForm"
                    >
                        <input
                            hidden
                            v-if="form.edit_product_id"
                            v-model="form.edit_product_id"
                            type="text"
                            name="store_id"
                        />

                        <input
                            hidden
                            v-model="form.store_id"
                            type="text"
                            name="store_id"
                        />

                        <input
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="form-control mt-2 mb-2"
                            placeholder="Product Name"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
                        />

                        <textarea
                            v-model="form.description"
                            name="description"
                            class="form-control mt-2 mb-2"
                            placeholder="Product Description"
                        ></textarea>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('description')"
                            v-html="form.errors.get('description')"
                        />

                        <input
                            v-model="form.price"
                            type="number"
                            name="price"
                            class="form-control mt-2 mb-2"
                            min="0"
                            placeholder="Product Price"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('price')"
                            v-html="form.errors.get('price')"
                        />

                        <label for="section-id" class="mt-2">
                            Choose Product Category
                        </label>
                        <select
                            id="section-id"
                            name="section_id"
                            v-model="form.section_id"
                            class="form-control"
                        >
                            <option
                                v-for="(section, index) in sections"
                                :key="index"
                                :value="section.id"
                            >
                                {{ section.name }}
                            </option>
                        </select>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('section_id')"
                            v-html="form.errors.get('section_id')"
                        />

                        <label for="product-stock" class="mt-2">
                            Product Stock
                        </label>
                        <select
                            id="product-stock"
                            name="stock"
                            v-model="form.stock"
                            class="form-control"
                        >
                            <option value="0">Not Avilable</option>
                            <option value="1" selected>Avilable</option>
                            <option value="2">Limited Quantity</option>
                        </select>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('stock')"
                            v-html="form.errors.get('stock')"
                        />

                        <label for="store-image mt-2"> Product Image </label>
                        <input
                            id="store-image"
                            type="file"
                            name="image"
                            class="form-control mt-2 mb-2"
                            @change="imageSelected"
                        />
                        <div class="justify-content-center d-flex">
                            <img
                                v-if="product_image"
                                :src="product_image"
                                class="rounded"
                                style="width: 150px; height: 150px"
                            />
                            <img
                                v-else
                                src="/image/products/newproduct.png"
                                class="rounded"
                                style="width: 150px; height: 150px"
                            />
                        </div>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('image')"
                            v-html="form.errors.get('image')"
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
                <div class="clear"></div>
                <!-- End Form Add New Member -->

                <div class="old-products" v-if="!addProductForm">
                    <div class="row">
                        <div class="col-md-2 p-0 pt-2">
                            <label for="new-product bold"
                                >Current Products</label
                            >
                        </div>
                        <div class="col-md-10">
                            <input
                                type="text"
                                v-model="productsearch"
                                id="new-product"
                                class="form-control"
                                placeholder="Search for a product"
                            />
                        </div>
                    </div>
                    <div
                        style="max-height: 400px; overflow: auto"
                        class="curret-section-table mt-2"
                    >
                        <table
                            class="table table-hover table-striped table-dark"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Section</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Proudct Stock</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="text-center"
                                    v-for="(product, index) in products"
                                    :key="index"
                                >
                                    <td class="pt-4">
                                        {{ product.name }}
                                    </td>
                                    <td class="pt-4">
                                        <span v-if="product.section">
                                            {{ product.section.name }}
                                        </span>
                                        <span v-else> N/A </span>
                                    </td>
                                    <td class="pt-4">{{ product.price }}</td>
                                    <td class="bold pt-4">
                                        <span v-if="product.stock == 0">
                                            Not Avilable
                                        </span>
                                        <span v-else-if="product.stock == 1">
                                            Avilable
                                        </span>
                                        <span v-else> limited quantity </span>
                                    </td>
                                    <td class="bold text-danger">
                                        <div>
                                            <img
                                                v-if="product.image"
                                                :src="
                                                    '/image/products/' +
                                                    product.image
                                                "
                                                class="rounded"
                                                alt="product image"
                                                style="
                                                    max-width: 90px;
                                                    max-height: 90px;
                                                "
                                            />
                                            <img
                                                v-else
                                                src="/image/products/newproduct.png"
                                                alt="product image"
                                                style="
                                                    max-width: 90px;
                                                    max-height: 90px;
                                                "
                                            />
                                        </div>
                                    </td>
                                    <td class="bold">
                                        <router-link
                                            :to="
                                                '?edit_product_id=' + product.id
                                            "
                                        >
                                            <i
                                                class="fas fa-edit btn btn-success"
                                            ></i
                                        ></router-link>
                                    </td>
                                    <td class="bold">
                                        <a
                                            href="#"
                                            @click="handleClick(product.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt btn btn-danger"
                                            ></i
                                        ></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div
                            class="text-center text-danger"
                            v-if="products.length < 1"
                        >
                            <h4 class="h4">
                                <span v-if="productsearch.length >= 1">
                                    There are no products with this name
                                </span>
                                <span v-else>
                                    There are no products, add products
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";

export default {
    name: "EditProducts",
    components: {},
    data: function () {
        return {
            addProductForm: false,
            store_id: this.$parent.store_id,
            products: {},
            sections: {},
            productsearch: "",
            form: new Form({
                name: "",
                description: "",
                price: "",
                image: "",
                stock: "",
                store_id: this.$parent.store_id,
                section_id: null,
                edit_product_id: null,
            }),
            product: {},
            product_image: null,
        };
    },
    mounted() {
        this.getProducts();
        this.getSections();
        this.urlReplace();
    },
    watch: {
        $route: function () {
            if (this.$route.query.edit_product_id) {
                this.form.edit_product_id = this.$route.query.edit_product_id;
                this.getProduct(this.$route.query.edit_product_id);
                this.addProductForm = !this.addProductForm;
            } else {
                this.form.edit_product_id = null;
            }
        },
        product: function () {
            this.form.name = this.product.name;
            this.form.description = this.product.description;
            this.form.price = this.product.price;
            this.form.stock = this.product.stock;
            this.form.edit_product_id = this.product.id;
            this.form.section_id = this.product.section_id;
            this.form.store_id = this.product.store_id;
        },
    },
    methods: {
        editproductsToggle() {
            this.$parent.editproducts = !this.$parent.editproducts;
        },
        getFormMethod: function () {
            if (this.$route.query.edit_product_id) this.updateproduct();
            else this.addNewProduct();
        },
        async addNewProduct() {
            const response = await this.form
                .post("/api/addnewproduct")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Section added successfully"
                    );
                    this.formEmpty();
                    this.urlReplace();
                    this.addProductForm = !this.addProductForm;
                    this.getProducts();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async updateproduct() {
            const response = await this.form
                .post("/api/updateproduct")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Section Updated Successfully"
                    );
                    this.formEmpty();
                    this.urlReplace();
                    this.addProductForm = !this.addProductForm;
                    this.getProducts();
                })
                .catch((err) => {
                    this.notification(
                        "warn",
                        "Warning",
                        "Warning To Updated Product"
                    );
                    console.log(err);
                });
        },
        cancelMethod: function () {
            this.formEmpty();
            this.urlReplace();
            this.addProductForm = !this.addProductForm;
        },
        getProducts: function () {
            axios
                .get(`/api/getproducts?store_id=${this.store_id}}`)
                .then((res) => {
                    // console.log(res.data);
                    this.products = res.data;
                })
                .catch((err) => {
                    // consol.log(err)
                });
        },
        getProduct: function (product_id) {
            axios
                .get(`/api/getproduct?edit_product_id=${product_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.product = res.data;
                })
                .catch((err) => console.log(err));
        },
        getSections: function () {
            axios
                .get(`/api/getsections?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.date)
                    this.sections = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteProduct: function (product_id) {
            axios
                .get(`/api/deleteproduct?product_id=${product_id}`)
                .then((res) => {
                    // console.log(res);
                    this.getProducts();
                    this.notification(
                        "success",
                        "Success",
                        "Deleted successfully"
                    );
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        handleClick: function (product_id) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        this.deleteProduct(product_id);
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

        formEmpty: function () {
            this.form.reset();
            this.product_image = null;
        },
        urlReplace: function () {
            this.$router
                .replace({
                    path: this.$route.path,
                })
                .catch(() => {});
        },
        imageSelected: function (e) {
            const file = e.target.files[0];
            this.form.image = file;
            this.onImageInput(e);
        },
        onImageInput(event) {
            const data = URL.createObjectURL(event.target.files[0]);
            this.product_image = data;
        },
    },
};
</script>
