<template>
    <div id="products-section">
        <div class="col-md-12 bg-new-warning bold p-2">
            <div class="row">
                <div class="col-md-4 p-0">
                    <h5 class="p-2">{{ lang.prudacts }}</h5>
                </div>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="search-products"
                        id="search-products"
                        autocomplete="true"
                        :placeholder="lang.search_products"
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
                {{ lang.all_products }}
            </h4>

            <h4
                v-if="products && products.length < 1"
                class="h4 bold text-center text-danger p-3"
            >
                {{ lang.no_items_yet }}
            </h4>
            <div class="clear"></div>
            <div class="row p-2">
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
                            <span v-if="product.price">
                                {{ product.price }}
                            </span>
                            USD
                        </div>
                        <a href="#">
                            <img
                                v-if="product.image"
                                class="product-image"
                                :src="'/image/products/' + product.image"
                                alt="product image"
                            />

                            <img
                                v-else
                                class="product-image"
                                src="/image/products/newproduct.png"
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
            lang: this.$parent.lang,
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
    mounted() {
        if (this.section_id != null) {
            this.getSections();
        }
    },
    methods: {
        addProductComponent: function (product_id) {
            this.addproduct_id = product_id;
            this.addProductsComponent = !this.addProductsComponent;
        },
        getSections: function () {
            axios
                .post(
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
