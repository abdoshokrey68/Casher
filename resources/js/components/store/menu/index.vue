<template>
    <div id="menu-page" class="bg-d-blue">
        <div class="container col-md-8 p-0 m-auto">
            <div class="menu-header bg-light">
                <img
                    src="/image/stores/fast-food.jpg"
                    alt="Store image"
                    class="rounded-circle"
                />
            </div>
            <!-- End menu-header Div -->
            <div class="menu-content bg-light">
                <div class="content-header">
                    <img
                        src="/image/menu/cover/fast-food.png"
                        class="p-0 store-cover"
                        alt="store-cover"
                        style="width: 100%"
                    />
                    <img
                        src="/image/stores/fast-food.jpg"
                        alt="Store image"
                        class="rounded-circle store-image"
                    />
                </div>
                <!-- End content-header Div -->
                <div class="clear"></div>
                <div class="menu-main-content">
                    <div class="row">
                        <div
                            class="col-md-4"
                            v-for="(section, index) in store_d.sections"
                            :key="index"
                        >
                            <img
                                :src="image1"
                                v-if="image1"
                                class="col-md-12"
                            />
                            <div v-if="section.products.length != 0">
                                <h4 class="h4 section-name p-0 pt-2 pb-2 bold">
                                    {{ section.name }}
                                    <i :class="getIconClass(section.icon)"></i>
                                </h4>
                                <div
                                    v-for="(product, index) in section.products"
                                    :key="index"
                                >
                                    <h6 class="h6 pt-2 float-end bold">
                                        {{ product.price + ".00" }}
                                    </h6>
                                    <h4 class="h4">{{ product.name }}</h4>
                                    <h6 class="h6">
                                        {{ "( " + product.description + " )" }}
                                    </h6>
                                    <hr class="m-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End menu-content Div -->
        </div>
    </div>
    <!-- End menu-page Div -->
</template>

<script>
import axios from "axios";
export default {
    name: "StoreMenu",
    props: ["store_id"],
    data: function () {
        return {
            store_d: {},
            image1: "/image/products/1.jpg",
        };
    },
    mounted() {
        this.getdetails(this.store_id);
    },
    methods: {
        getIconClass: function (icon) {
            if (icon) {
                return icon + " float-end";
            }
        },
        getdetails: function (store_id) {
            axios
                .get(`/api/store_d?store_id=${store_id}`)
                .then((res) => {
                    console.log(res.data);
                    this.store_d = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
