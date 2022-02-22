<template>
    <div
        id="menu-page"
        class="bg-d-blue"
        :style="'background-color:' + menu.background_co + '!important'"
    >
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
                                {{ lang.join_us }}
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
                                type="number"
                                name="store_id"
                            />
                            <label for="phone">
                                <i
                                    class="fas fa-bell text-warning bold mr-2 ml-2"
                                ></i>
                                {{ lang.latest_offers }}
                            </label>
                            <input
                                v-model="form.phone"
                                type="phone"
                                name="phone"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.whatsapp_number"
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
                                    {{ lang.join_now }}
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-light text-danger"
                                    @click="joinForm = !joinForm"
                                >
                                    <i class="fas fa-times mt-2 ml-2"></i>
                                    {{ lang.cancel }}
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
                            v-if="section.products.length != 0"
                        >
                            <div>
                                <img
                                    :src="
                                        '/image/products/' +
                                        section.products[0].image
                                    "
                                    style="width: 100%; max-height: 150px"
                                />
                                <h4
                                    class="h4 section-name p-0 pt-2 pb-2 bold"
                                    :style="
                                        'color:' +
                                        menu.heading_co +
                                        '!important'
                                    "
                                >
                                    <span class="mr-2 ml-2">
                                        {{ section.name }}
                                    </span>

                                    <i
                                        v-if="section.icon"
                                        :class="section.icon + ' float-end'"
                                        :style="
                                            'color:' +
                                            menu.icon_co +
                                            '!important'
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
                                    <h6
                                        :style="
                                            'color:' +
                                            menu.price_co +
                                            '!important'
                                        "
                                        :class="getFloat()"
                                    >
                                        {{ product.price }}
                                        <i
                                            class="fas fa-coin text-warning mr-1 ml-1"
                                        ></i>
                                    </h6>
                                    <h6
                                        class="h6"
                                        :style="
                                            'color:' +
                                            menu.text_co +
                                            '!important'
                                        "
                                    >
                                        {{ product.name }}
                                        <!-- <p`
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
                                    </h6>
                                    <h6
                                        v-if="product.description"
                                        :style="
                                            'color:' +
                                            menu.des_co +
                                            '!important'
                                        "
                                        class="h6 bold"
                                    >
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
        <!-- <main-footer /> -->
        <notifications group="dashboard" />
        <!-- VUE NOTIFICATION COMPONENT -->
    </div>
    <!-- End menu-page Div -->
</template>

<script>
import Form from "vform";
import axios from "axios";
// import mainFooter from "../layouts/mainFooter.vue";
export default {
    // components: { mainFooter },
    name: "StoreMenu",
    props: ["store_id"],
    data: function () {
        return {
            store_d: {},
            joinForm: false,
            date_30: "",
            menu: {},
            form: new Form({
                store_id: this.store_id,
                phone: null,
            }),
            locale: "",
            lang: this.getLang(),
        };
    },
    mounted() {
        this.getdetails(this.store_id);
        this.getStoreMenu();
        this.getDate();
        this.locale = this.getLocale();
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
                .get("/api/audience/add")
                .then((res) => {
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_has_sent
                    );
                    // console.log(res.data);
                    this.form.reset();
                    this.joinForm = !this.joinForm;
                })
                .catch((err) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.went_wrong
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
        getStoreMenu: function () {
            axios
                .get(`/api/store/menu?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.menu = res.data;
                })
                .catch((err) => console.log(err));
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
        getFloat: function () {
            if (this.locale == "ar") {
                return "h6  float-start bold";
            } else {
                return "h6  float-end bold";
            }
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
