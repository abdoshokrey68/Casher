<template>
    <div id="edit-store-info" class="col-md-5 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="edit-store-info-header">
                <button
                    @click="storesettingsToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-store"></i> {{ lang.store_info }}
                </h2>
            </div>
            <!-- End Edit Store Settings Header -->
            <div class="edit-store-info content p-2">
                <div>
                    <form
                        @submit.prevent="handleClick()"
                        @keydown="form.onKeydown($event)"
                        enctype="multipart/form-data"
                        role="form"
                        class="form-horizontal"
                    >
                        <div class="clear"></div>
                        <label for="store-name"> {{ lang.store_name }} </label>
                        <input
                            id="store-name"
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.store_name"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
                        />

                        <div class="clear"></div>
                        <label for="store-description">
                            {{ lang.store_des }}</label
                        >
                        <textarea
                            v-model="form.description"
                            id="store-description"
                            name="description"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.store_des"
                            rows="4"
                            cols="50"
                        ></textarea>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('description')"
                            v-html="form.errors.get('description')"
                        />

                        <div class="clear"></div>
                        <label for="store-email"> {{ lang.store_email }}</label>
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

                        <!-- <div class="clear"></div>
                        <label for="store-password">
                            {{ lang.store_password }}</label
                        >
                        <input
                            id="store-password"
                            v-model="form.password"
                            type="password"
                            name="password"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.store_password"
                            autocomplete="new-password"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('password')"
                            v-html="form.errors.get('password')"
                        />
                        <ul v-if="form.password" class="list-group">
                            <li class="">
                                <i
                                    class="fas fa-check text-primary bold mr-2 ml-2"
                                ></i>
                                {{ lang.pass_must_not }}
                            </li>
                            <li class="">
                                <i
                                    class="fas fa-check text-primary bold mr-2 ml-2"
                                ></i>
                                {{ lang.pass_must_contain }}
                            </li>
                            <li class="">
                                <i
                                    class="fas fa-check text-primary bold mr-2 ml-2"
                                ></i>
                                {{ lang.pass_symbols }}
                            </li>
                        </ul> -->

                        <div class="clear"></div>
                        <div class="store-phone">
                            <label for="store-phone">
                                {{ lang.store_phone }}</label
                            >
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

                        <div class="clear"></div>
                        <div class="store-phone2">
                            <label for="store-phone2">
                                {{ lang.store_phone2 }}</label
                            >
                            <input
                                id="store-phone2"
                                v-model="form.phone2"
                                type="text"
                                name="phone2"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.store_phone2"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('phone2')"
                                v-html="form.errors.get('phone2')"
                            />
                        </div>

                        <div class="clear"></div>
                        <div class="fb">
                            <label for="fb">
                                {{ lang.fb }} {{ lang.optional }}
                            </label>
                            <input
                                id="fb"
                                v-model="form.fb"
                                type="url"
                                name="fb"
                                class="form-control mt-2 mb-2"
                                :placeholder="lang.fb"
                            />
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('fb')"
                                v-html="form.errors.get('fb')"
                            />
                        </div>

                        <div class="clear"></div>
                        <label for="store-currency">
                            {{ lang.currency_code }}
                        </label>
                        <input
                            id="store-currency"
                            v-model="form.currency"
                            type="text"
                            name="currency"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.currency_code"
                        />
                        <small> {{ lang.currency_like }} </small>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('currency')"
                            v-html="form.errors.get('currency')"
                        />
                        <div class="clear"></div>

                        <label for="store-discount">
                            {{ lang.store_discount }}
                        </label>
                        <input
                            id="store-discount"
                            v-model="form.discount"
                            type="number"
                            name="discount"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.store_discount"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('discount')"
                            v-html="form.errors.get('discount')"
                        />

                        <div class="clear"></div>
                        <label for="store-location">
                            {{ lang.store_location }}
                        </label>
                        <input
                            id="store-location"
                            v-model="form.location"
                            type="text"
                            name="location"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.store_location"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('location')"
                            v-html="form.errors.get('location')"
                        />
                        <div class="form-check form-switch">
                            <input
                                id="store-audience"
                                v-model="form.audience"
                                type="checkbox"
                                name="audience"
                                class="form-check-input mt-2 mb-2"
                            />
                            <label
                                class="form-check-label p-1"
                                for="store-audience"
                                >{{ lang.store_audience }}</label
                            >
                            <div class="clear"></div>
                            <small class="text-primary bold">
                                {{ lang.receive_phone_numbers }}
                            </small>
                        </div>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('audience')"
                            v-html="form.errors.get('audience')"
                        />

                        <div class="clear"></div>
                        <label for="store-image"
                            >{{ lang.store_image }} :
                        </label>
                        <input
                            type="file"
                            name="image"
                            class="form-control mt-2 mb-2"
                            @change="imageSelected"
                        />
                        <img
                            v-if="my_photo"
                            :src="my_photo"
                            class="m-auto d-block rounded-circle"
                            style="width: 300px; height: 300px"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('image')"
                            v-html="form.errors.get('image')"
                        />

                        <div class="clear"></div>
                        <label for="store-cover"
                            >{{ lang.store_cover }} :
                        </label>
                        <input
                            id="store-cover"
                            type="file"
                            name="cover"
                            class="form-control mt-2 mb-2"
                            @change="coverSelected"
                        />

                        <img
                            v-if="my_cover"
                            :src="my_cover"
                            class="m-auto d-block"
                            style="width: 100%; height: 300px"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('cover')"
                            v-html="form.errors.get('cover')"
                        />

                        <div class="float-end mt-3">
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
                                {{ lang.edit_info }}
                            </button>

                            <button
                                @click.prevent="storesettingsToggle()"
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
    </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
    name: "storeSettings",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            storeinfo: {},
            my_photo: null,
            my_cover: null,
            form: new Form({
                name: null,
                slug: null,
                description: null,
                image: null,
                cover: null,
                location: null,
                phone: null,
                phone2: null,
                fb: null,
                audience: false,
                email: null,
                currency: "EGP",
                discount: 0,
                store_id: this.$parent.store_id,
            }),
            locale: null,
            lang: this.$parent.lang,
        };
    },
    mounted() {
        this.getStoreInfo();
        this.locale = this.getLocale();
    },
    watch: {
        storeinfo: function () {
            this.form.name = this.storeinfo.name;
            this.form.slug = this.storeinfo.slug;
            this.form.description = this.storeinfo.description;
            this.form.location = this.storeinfo.location;
            this.form.phone = this.storeinfo.phone;
            this.form.phone2 = this.storeinfo.phone2;
            this.form.fb = this.storeinfo.fb;
            this.form.email = this.storeinfo.email;
            this.form.currency = this.storeinfo.currency;
            this.form.discount = this.storeinfo.discount;
            this.form.store_id = this.storeinfo.id;
            if (this.storeinfo.audience == 0) {
                this.form.audience = false;
            } else {
                this.form.audience = true;
            }
        },
    },
    methods: {
        storesettingsToggle: function () {
            this.$parent.storesettings = !this.$parent.storesettings;
        },
        async editStoreSettings(password) {
            const response = await this.form
                .post("/api/updateinfo")
                .then((res) => {
                    // console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_modified
                    );
                    this.getStoreInfo();
                })
                .catch((err) => {
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.please_check_the_data
                    );
                });
        },
        getStoreInfo: function () {
            axios
                .get(`/api/storeinfo?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.storeinfo = res.data;
                })
                .catch((err) => {
                    // console.log(err);
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
        handleClick: function () {
            this.$confirm({
                auth: true,
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm, password) => {
                    if (confirm) {
                        this.form.password = password;
                        this.editStoreSettings(password);
                    }
                },
            });
        },
        imageSelected: function (e) {
            const file = e.target.files[0];
            this.form.image = file;
            // console.log(file);
            this.onImageInput(e);
        },
        onImageInput(event) {
            const data = URL.createObjectURL(event.target.files[0]);
            this.my_photo = data;
        },
        coverSelected: function (e) {
            const file = e.target.files[0];
            this.form.cover = file;
            // console.log(file);
            this.onCoverInput(e);
        },
        onCoverInput(event) {
            const data = URL.createObjectURL(event.target.files[0]);
            this.my_cover = data;
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
