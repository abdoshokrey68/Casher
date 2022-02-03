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
                                    <i
                                        v-if="section.icon"
                                        :class="getIconClass(section.icon)"
                                    ></i>
                                    <!-- <span
                                        class="btn btn-danger p-1 mr-2 ml-2 float-end bold"
                                    >
                                        {{ section.discount }} %
                                    </span> -->
                                </h4>
                                <div
                                    v-for="(product, index) in section.products"
                                    :key="index"
                                >
                                    <h6 class="h6 pt-2 float-end bold">
                                        {{ product.price + ".00" }}
                                    </h6>
                                    <h5 class="h5">
                                        {{ product.name }}
                                        <!-- <p
                                            v-if="
                                                getNewProducts(
                                                    product.created_at
                                                )
                                            "
                                            class="text-light p-1 m-0 bold btn btn-danger"
                                            style="background-color: #eb5700"
                                        >
                                            New
                                        </p> -->
                                    </h5>
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
            date_30: "",
        };
    },
    mounted() {
        this.getdetails(this.store_id);
        this.getDate();
    },
    methods: {
        getNewProducts: function (date) {
            if (date > this.date_30) {
                return true;
            } else {
                return false;
            }
        },
        getIconClass: function (icon) {
            if (icon) {
                return icon + " float-end mr-2 ml-2";
            }
        },
        getDate() {
            var date = new Date();
            var year = date.getFullYear();
            var monthCount = date.getMonth();
            // var month = months[monthCount].substring(0, 3);
            var day = date.getDay() - 30;
            this.date_30 = day + "-" + monthCount + "-" + year;
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
