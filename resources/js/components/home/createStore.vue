<template>
    <div id="create-store">
        <div class="row mb-5" style="min-height: 90vh">
            <div
                class="col-md-10 p-0 mt-5 m-auto create-box"
                style="box-shadow: 8px 15px 15px #504ca0"
            >
                <div class="row">
                    <div class="col-md-6 p-0 d-flex">
                        <img
                            src="/image/home/create-store.jpg"
                            alt="create store"
                            style="width: 100%"
                        />
                    </div>
                    <div class="col-md-6 p-2">
                        <div class="create-store-heading row">
                            <h4
                                class="h4 p-2 m-auto text-center bold col-md-8"
                                style="border-bottom: 2px solid #514da2"
                            >
                                <i class="fas fa-store mr-2 ml-2"></i>
                                {{ lang.create_new_store }}
                            </h4>
                        </div>
                        <form
                            @submit.prevent="addNewStore()"
                            @keydown="form.onKeydown($event)"
                            class="mt-2"
                        >
                            <div class="store-name">
                                <label for="store-name">
                                    <i class="fas fa-signature mr-1 ml-1"></i>
                                    {{ lang.store_name }}
                                </label>
                                <input
                                    id="store-name"
                                    v-model="form.name"
                                    type="name"
                                    name="name"
                                    class="form-control mt-2 mb-2"
                                    :placeholder="lang.store_name"
                                />
                                <div
                                    class="text-danger bold"
                                    v-if="form.errors.has('name')"
                                    v-html="form.errors.get('name')"
                                />
                            </div>

                            <div class="store-email">
                                <label for="store-email">
                                    <i
                                        class="fas fa-envelope-open-text mr-1 ml-1"
                                    ></i>
                                    {{ lang.store_email }}
                                </label>
                                <input
                                    id="store-email"
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    class="form-control mt-2 mb-2"
                                    :placeholder="lang.store_email"
                                />
                                <div
                                    class="text-danger bold"
                                    v-if="form.errors.has('email')"
                                    v-html="form.errors.get('email')"
                                />
                            </div>

                            <div class="store-phone">
                                <label for="store-phone">
                                    <i class="fas fa-mobile-alt mr-1 ml-1"></i>
                                    {{ lang.store_phone }}
                                </label>
                                <input
                                    id="store-phone"
                                    v-model="form.phone"
                                    type="text"
                                    name="phone"
                                    class="form-control mt-2 mb-2"
                                    :placeholder="lang.store_phone"
                                />
                                <div
                                    class="text-danger bold"
                                    v-if="form.errors.has('phone')"
                                    v-html="form.errors.get('phone')"
                                />
                            </div>

                            <div class="store-location">
                                <label for="store-location">
                                    <i
                                        class="fas fa-map-marker-alt mr-1 ml-1"
                                    ></i>
                                    {{ lang.store_location }} :</label
                                >
                                <input
                                    id="store-location"
                                    v-model="form.location"
                                    type="map"
                                    name="location"
                                    class="form-control mt-2 mb-2"
                                    :placeholder="lang.store_location"
                                />
                                <div
                                    class="text-danger bold"
                                    v-if="form.errors.has('location')"
                                    v-html="form.errors.get('location')"
                                />
                            </div>

                            <div class="store-currency">
                                <label for="store-currency">
                                    <i
                                        class="fas fa-map-marker-alt mr-1 ml-1"
                                    ></i>
                                    {{ lang.currency_code }}
                                </label>
                                <input
                                    id="store-currency"
                                    v-model="form.currency"
                                    type="map"
                                    name="currency"
                                    class="form-control mt-2 mb-2"
                                    :placeholder="lang.currency_like"
                                />
                                <div
                                    class="text-danger bold"
                                    v-if="form.errors.has('currency')"
                                    v-html="form.errors.get('currency')"
                                />
                            </div>

                            <div class="float-end mt-2">
                                <a
                                    v-if="route"
                                    :href="route"
                                    class="btn btn-primary mb-2"
                                >
                                    <i class="fas fa-store m-2"></i>
                                    {{ lang.go_to_y_store }}
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-dark mb-2"
                                    :disabled="form.busy"
                                >
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        :hidden="!form.busy"
                                    ></span>
                                    <i
                                        class="fas fa-plus m-2"
                                        :hidden="form.busy"
                                    ></i>
                                    {{ lang.create_new_store }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <notifications group="dashboard" />
            <!-- VUE NOTIFICATION COMPONENT -->
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "CreateStore",
    data: function () {
        return {
            storeName: null,
            route: null,
            form: new Form({
                name: null,
                email: null,
                phone: null,
                location: null,
                currency: null,
            }),
            locale: this.getLocale(),
            lang: this.getLang(),
        };
    },
    methods: {
        async addNewStore() {
            const response = await this.form
                .post("/api/add-new-store")
                .then((res) => {
                    // console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.store_create_success
                    );
                    this.storeName = res.data.storeName;
                    this.route = res.data.route;
                    this.form.reset();
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.went_wrong
                    );
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
