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
                    <i class="fas fa-store"></i> Store Information
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
                        <input
                            hidden
                            v-model="form.store_id"
                            type="text"
                            name="store_id"
                        />

                        <label for="store-name"> Store Name</label>
                        <input
                            id="store-name"
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Name"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
                        />

                        <label for="store-description">
                            Store Description</label
                        >
                        <textarea
                            v-model="form.description"
                            id="store-description"
                            name="description"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Description"
                            rows="4"
                            cols="50"
                        ></textarea>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('description')"
                            v-html="form.errors.get('description')"
                        />

                        <label for="store-email"> Store Email</label>
                        <input
                            id="store-email"
                            v-model="form.email"
                            type="email"
                            name="email"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Email"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('email')"
                            v-html="form.errors.get('email')"
                        />
                        <label for="store-phone"> Store Phone</label>
                        <input
                            id="store-phone"
                            v-model="form.phone"
                            type="text"
                            name="phone"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Phone"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('phone')"
                            v-html="form.errors.get('phone')"
                        />

                        <label for="store-currency">
                            Store Currency Code
                        </label>
                        <input
                            id="store-currency"
                            v-model="form.currency"
                            type="text"
                            name="currency"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Currency Code "
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('currency')"
                            v-html="form.errors.get('currency')"
                        />

                        <label for="store-discount"> Store Discount </label>
                        <input
                            id="store-discount"
                            v-model="form.discount"
                            type="text"
                            name="discount"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Discount"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('discount')"
                            v-html="form.errors.get('discount')"
                        />

                        <label for="store-location"> Store Location </label>
                        <input
                            id="store-location"
                            v-model="form.location"
                            type="text"
                            name="location"
                            class="form-control mt-2 mb-2"
                            placeholder="Store Location"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('location')"
                            v-html="form.errors.get('location')"
                        />

                        <label for="store-image">Store Image : </label>
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

                        <label for="store-cover">Store Cover : </label>
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
                                Edit Information
                            </button>

                            <button
                                @click.prevent="storesettingsToggle()"
                                class="btn btn-light text-danger bold"
                            >
                                <i class="fas fa-times mt-2 ml-2"></i> Cancel
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

export default {
    name: "storeSettings",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            storeinfo: "",
            buttonloading: false,
            my_photo: null,
            my_cover: null,
            form: new Form({
                name: "",
                slug: "",
                description: "",
                image: null,
                cover: null,
                location: "",
                phone: "",
                email: "",
                currency: "EGP",
                manager_id: "",
                discount: 0,
                store_id: this.$parent.store_id,
            }),
        };
    },
    mounted() {
        this.getStoreInfo();
    },
    watch: {
        storeinfo: function () {
            this.form.name = this.storeinfo.name;
            this.form.slug = this.storeinfo.slug;
            this.form.description = this.storeinfo.description;
            this.form.location = this.storeinfo.location;
            this.form.phone = this.storeinfo.phone;
            this.form.email = this.storeinfo.email;
            this.form.currency = this.storeinfo.currency;
            this.form.manager_id = this.storeinfo.manager_id;
            this.form.discount = this.storeinfo.discount;
            this.form.store_id = this.storeinfo.id;
        },
    },
    methods: {
        storesettingsToggle: function () {
            this.$parent.storesettings = !this.$parent.storesettings;
        },
        async editStoreSettings() {
            this.buttonloading = !this.buttonloading;
            const response = await this.form
                .post("/api/updateinfo")
                .then((res) => {
                    // console.log(res.data);
                    this.notification(
                        "success",
                        "Success",
                        "The data has been modified successfully"
                    );
                    this.buttonloading = !this.buttonloading;
                    this.getStoreInfo();
                })
                .catch((err) => {
                    this.buttonloading = !this.buttonloading;
                    this.notification(
                        "error",
                        "Error",
                        "The data is not updated, there seems to be a problem"
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
                .catch((err) => console.log(err));
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
                    if (confirm && password == "1234") {
                        this.editStoreSettings();
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
    },
};
</script>
