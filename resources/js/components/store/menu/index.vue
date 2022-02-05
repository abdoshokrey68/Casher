<template>
    <div id="menu-page" class="bg-d-blue">
        <div class="container col-md-8 p-0 pb-5 pt-5 m-auto">
            <div class="menu-header bg-light mb-5">
                <img
                    v-if="store_d.image"
                    :src="'/image/stores/image/' + store_d.image"
                    alt="Store image"
                    class="rounded-circle store-image"
                />
                <img
                    v-else
                    src="/image/stores/image/store1.jpg"
                    alt="Store image"
                    class="rounded-circle store-image"
                />
            </div>
            <!-- End menu-header Div -->
            <div class="menu-content bg-light">
                <div class="content-header border-bottom border-2">
                    <img
                        v-if="store_d.cover"
                        :src="'/image/stores/cover/' + store_d.cover"
                        class="p-0 store-cover"
                        alt="store-cover"
                        style="width: 100%; height: 250px"
                    />
                    <img
                        v-else
                        src="/image/stores/cover/fast-food.png"
                        class="p-0 store-cover"
                        alt="store-cover"
                        style="width: 100%; height: 250px"
                    />
                    <img
                        v-if="store_d.image"
                        :src="'/image/stores/image/' + store_d.image"
                        alt="Store image"
                        class="rounded-circle store-image"
                    />
                    <img
                        v-else
                        src="/image/stores/image/store1.jpg"
                        alt="Store image"
                        class="rounded-circle store-image"
                    />
                </div>
                <!-- End content-header Div -->
                <div class="clear"></div>
                <div class="menu-main-content">
                    <div
                        v-if="store_d.audience == 1"
                        class="add-audience m-auto p-2 col-md-5"
                    >
                        <div class="m-auto">
                            <button
                                v-if="!joinForm"
                                type="submit"
                                class="btn btn-primary m-auto d-block col-md-12 mb-3"
                                style="width: -webkit-fill-available"
                                @click="joinForm = !joinForm"
                            >
                                <i
                                    class="fas fa-plus mt-2 ml-2"
                                    :hidden="form.busy"
                                ></i>
                                Join Us
                            </button>
                        </div>
                        <form
                            class="col-md-12"
                            v-if="joinForm"
                            @submit.prevent="addaudience()"
                            @keydown="form.onKeydown($event)"
                        >
                            <input
                                hidden
                                v-model="form.store_id"
                                type="integer"
                                name="store_id"
                            />
                            <label for="phone">
                                <i
                                    class="fas fa-bell text-warning bold mr-2 ml-2"
                                ></i>
                                To know the latest offers, you can join us and
                                leave your phone number
                            </label>
                            <input
                                v-model="form.phone"
                                type="phone"
                                name="phone"
                                class="form-control mt-2 mb-2"
                                placeholder="Enter Your WhatsApp Number"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('phone')"
                                v-html="form.errors.get('phone')"
                            />

                            <div class="float-end mt-2">
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
                                    Join Now
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-light text-danger"
                                    @click="joinForm = !joinForm"
                                >
                                    <i class="fas fa-times mt-2 ml-2"></i>
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="clear"></div>
                    <div class="row mt-3">
                        <div
                            class="col-md-4"
                            v-for="(section, index) in store_d.sections"
                            :key="index"
                        >
                            <div v-if="section.products.length != 0">
                                <img
                                    :src="image1"
                                    v-if="image1"
                                    style="width: 100%"
                                />
                                <h4 class="h4 section-name p-0 pt-2 pb-2 bold">
                                    {{ section.name }}
                                    <i
                                        v-if="section.icon"
                                        :class="
                                            section.icon +
                                            ' float-end mr-2 ml-2'
                                        "
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
                                        <i
                                            class="fas fa-coin text-warning mr-1 ml-1"
                                        ></i>
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
        <notifications group="dashboard" />
        <!-- VUE NOTIFICATION COMPONENT -->
    </div>
    <!-- End menu-page Div -->
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
    name: "StoreMenu",
    props: ["store_id"],
    data: function () {
        return {
            store_d: {},
            joinForm: false,
            image1: "/image/products/1.jpg",
            date_30: "",
            form: new Form({
                store_id: this.store_id,
                phone: null,
            }),
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
        async addaudience() {
            const response = await this.form
                .get("/api/store/addaudience")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Data has been sent"
                    );
                    // console.log(res.data);
                    this.form.reset();
                    this.joinForm = !this.joinForm;
                })
                .catch((err) => {
                    this.notification(
                        "error",
                        "Error",
                        "Something went wrong Check the data"
                    );
                    // console.log(err);
                });
        },
        getIconClass: function (icon) {
            if (icon) {
                return;
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
        notification: function (type, title, text) {
            this.$notify({
                group: "dashboard",
                speed: 1500,
                type: type, // error , warn, success
                title: title,
                text: text,
            });
        },
    },
};
</script>
