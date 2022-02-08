<template>
    <div id="products-section">
        <div class="col-md-12 bg-new-warning bold p-2">
            <div class="row">
                <div class="col-md-4 p-0">
                    <h5 class="pt-2">Prodacts</h5>
                </div>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="search-products"
                        id="search-products"
                        placeholder="Search Prodacts"
                    />
                </div>
            </div>
        </div>
        <!-- End Of Products Header -->
        <div class="products-details">
            <h4
                class="h4 bold border-bottom p-3"
                v-if="sectionDetails && section_id > 0"
            >
                {{ sectionDetails.name }}
            </h4>
            <h4 class="h4 bold border-bottom p-3" v-if="section_id == 0">
                All Products
            </h4>

            <h4
                v-if="products && products.length < 1"
                class="h4 bold text-center text-danger p-3"
            >
                There are no items yet
            </h4>
            <div class="clear"></div>
            <div class="row">
                <div
                    v-for="(product, index) in products"
                    :key="index"
                    class="col-md-4 product p-1 mt-2"
                    @click="addProductComponent(product.id)"
                >
                    <div class="card position-relative">
                        <div
                            class="btn m-0 p-0 m-1 text-dark bold position-absolute bg-light"
                            style="right=0;"
                        >
                            {{ product.price }}
                            USD
                        </div>
                        <a href="#">
                            <img
                                class="product-image"
                                :src="'/image/products/' + product.image"
                                alt="product image"
                            />
                            <a
                                class="text-center btn col-md-12 m-0 p-0 small m-1 text-dark bold"
                            >
                                {{ product.name }}
                            </a>
                        </a>
                    </div>
                </div>

                <div class="add-product-layout-box">
                    <div
                        class="add-product"
                        v-if="addProductsComponent"
                        @click.self="addProductComponent(null)"
                    >
                        <add-products
                            :product_id="addproduct_id"
                        ></add-products>
                    </div>
                </div>
                <!-- End Add Product To Invoice Box -->
            </div>
        </div>
        <!-- End Of Products Details -->
    </div>
</template>

<script>
import addProducts from "../smallLayouts/addProducts.vue";
export default {
    components: { addProducts },
    name: "productsSection",
    data: function () {
        return {
            store_id: this.$parent.store_id,
            section_id: null,
            sectionDetails: null,
            products: {},
            addProductsComponent: false,
            addproduct_id: null,
        };
    },
    watch: {
        $route: function () {
            if (this.$route.query.section) {
                this.section_id = this.$route.query.section;
                this.getSections();
            } else {
                this.products = {};
            }
        },
        // Get The New Section Parameter
    },
    mounted() {},
    methods: {
        addProductComponent: function (product_id) {
            this.addproduct_id = product_id;
            this.addProductsComponent = !this.addProductsComponent;
        },
        getSections() {
            axios
                .get(
                    `/api/sectiondet?store_id=${this.store_id}&section_id=${this.section_id}`
                )
                .then((res) => {
                    if (this.section_id != 0) {
                        // console.log(res.data.products);
                        this.sectionDetails = res.data;
                        this.products = res.data.products;
                    } else {
                        // console.log(res.data);
                        this.products = res.data;
                    }
                });
        },
    },
};
</script>
