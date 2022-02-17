<template>
    <div id="store-menu" class="col-md-6 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-menu-header">
                <button
                    @click="storeMenuToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.store_menu }}
                </h2>
            </div>
            <!-- End Edit Menu Header -->
            <div class="store-menu-controller content p-2">
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
                <!-- End Of Export To Box  -->
                <div class="store-menu-controller">
                    <div class="qr-code-box">
                        <div class="card row">
                            <div class="card-header">
                                <h5 class="h5">{{ lang.menu_qr_code }}</h5>
                            </div>
                            <div class="card-body row col-md-6 m-auto">
                                <img
                                    v-if="menu.qrcode_name"
                                    :src="'/image/menu/QR/' + menu.qrcode_name"
                                    class="col-md-10 m-auto"
                                    alt="Menu-Qr"
                                />
                                <a
                                    id="downloadQr"
                                    :href="'/image/menu/QR/' + menu.qrcode_name"
                                    class="btn btn-primary d-block mt-2"
                                    download
                                >
                                    {{ lang.download_qr }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End QR Code Box -->
                    <div class="card mt-3">
                        <div class="menu-design">
                            <div class="card-header">
                                <h5 class="h5">{{ lang.edit_menu_des }}</h5>
                            </div>
                            <div class="card-body row">
                                <form
                                    @submit.prevent="updateStoreMenu()"
                                    @keydown="form.onKeydown($event)"
                                >
                                    <input
                                        hidden
                                        v-model="form.store_id"
                                        type="text"
                                        name="store_id"
                                    />

                                    <div class="background-color">
                                        <label for="background_co">{{
                                            lang.bg_co
                                        }}</label>
                                        <input
                                            id="background_co"
                                            v-model="form.background_co"
                                            type="color"
                                            name="background_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="text-danger bold"
                                            v-if="
                                                form.errors.has('background_co')
                                            "
                                            v-html="
                                                form.errors.get('background_co')
                                            "
                                        />
                                    </div>

                                    <div class="text-color">
                                        <label for="text_co">
                                            {{ lang.text_co }}
                                        </label>
                                        <input
                                            id="text_co"
                                            v-model="form.text_co"
                                            type="color"
                                            name="text_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="text-danger bold"
                                            v-if="form.errors.has('text_co')"
                                            v-html="form.errors.get('text_co')"
                                        />
                                    </div>

                                    <div class="des-color">
                                        <label for="des_co">{{
                                            lang.product_des_co
                                        }}</label>
                                        <input
                                            id="des_co"
                                            v-model="form.des_co"
                                            type="color"
                                            name="des_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="des-danger bold"
                                            v-if="form.errors.has('des_co')"
                                            v-html="form.errors.get('des_co')"
                                        />
                                    </div>

                                    <div class="price-color">
                                        <label for="price_co">{{
                                            lang.price_co
                                        }}</label>
                                        <input
                                            id="price_co"
                                            v-model="form.price_co"
                                            type="color"
                                            name="price_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="price-danger bold"
                                            v-if="form.errors.has('price_co')"
                                            v-html="form.errors.get('price_co')"
                                        />
                                    </div>

                                    <div class="icon-color">
                                        <label for="icon_co">
                                            {{ lang.icon_co }}
                                        </label>
                                        <input
                                            id="icon_co"
                                            v-model="form.icon_co"
                                            type="color"
                                            name="icon_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="icon-danger bold"
                                            v-if="form.errors.has('icon_co')"
                                            v-html="form.errors.get('icon_co')"
                                        />
                                    </div>

                                    <div class="heading-color">
                                        <label for="heading_co">{{
                                            lang.heading_co
                                        }}</label>
                                        <input
                                            id="heading_co"
                                            v-model="form.heading_co"
                                            type="color"
                                            name="heading_co"
                                            class="form-control form-control-color"
                                        />
                                        <div
                                            class="text-danger bold"
                                            v-if="form.errors.has('heading_co')"
                                            v-html="
                                                form.errors.get('heading_co')
                                            "
                                        />
                                    </div>

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
                                            {{ lang.edit_design }}
                                        </button>

                                        <button
                                            @click.prevent="storeMenuToggle()"
                                            class="btn btn-light text-danger bold"
                                        >
                                            <i
                                                class="fas fa-times mt-2 ml-2"
                                            ></i>
                                            {{ lang.cancel }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- 'store_id', 'design_no','background_co', 'text_co', 'heading_co' -->
                        </div>
                    </div>
                    <!-- End Menu Design Box -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "StoreMenu",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            menu: {},
            lang: this.$parent.lang,
            form: new Form({
                store_id: this.$parent.store_id,
                design_no: null,
                background_co: null,
                text_co: null,
                heading_co: null,
                des_co: null,
                icon_co: null,
                price_co: null,
            }),
        };
    },
    mounted() {
        this.getStoreMenu();
    },
    watch: {
        menu: function () {
            if (!this.menu.text_co) {
                this.storeMenuToggle();
            }
            this.form.design_no = this.menu.design_no;
            this.form.background_co = this.menu.background_co;
            this.form.text_co = this.menu.text_co;
            this.form.heading_co = this.menu.heading_co;
            this.form.des_co = this.menu.des_co;
            this.form.icon_co = this.menu.icon_co;
            this.form.price_co = this.menu.price_co;
            this.base64SvgToBase64Png(
                require(`/image/menu/QR/${this.menu.qrcode_name}`),
                300
            );
        },
    },
    methods: {
        storeMenuToggle: function () {
            this.$parent.storemenu = !this.$parent.storemenu;
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
        async updateStoreMenu() {
            const response = await this.form
                .post("/api/store/menu")
                .then((res) => {
                    console.log(res.data);
                    this.notification(
                        "success",
                        "Success",
                        "The data has been modified successfully"
                    );
                    this.form.reset();
                    this.getStoreMenu();
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        "error",
                        "Error",
                        "There is a problem, please check the data and try again"
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
        base64SvgToBase64Png: function (originalBase64, width) {
            return new Promise((resolve) => {
                let img = document.createElement("img");
                img.onload = function () {
                    document.body.appendChild(img);
                    let canvas = document.createElement("canvas");
                    let ratio = img.clientWidth / img.clientHeight || 1;
                    document.body.removeChild(img);
                    canvas.width = width;
                    canvas.height = width / ratio;
                    let ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    try {
                        let data = canvas.toDataURL("image/png");
                        resolve(data);
                    } catch (e) {
                        resolve(null);
                    }
                };
                img.src = originalBase64;
                var btn = document.getElementById("downloadQr");
                // btn.href = originalBase64.default;
                console.log(btn.getAttribute("href"));
                btn.setAttribute("href", "originalBase64.default");
            });
        },
    },
};
</script>
