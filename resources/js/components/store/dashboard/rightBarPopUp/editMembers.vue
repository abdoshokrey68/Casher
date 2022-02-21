<template>
    <div id="new-members" class="col-md-8 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-members-header">
                <button
                    @click="editmembersToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-users-cog"></i> {{ lang.user_manage }}
                </h2>
            </div>
            <!-- End Edit Members Header -->
            <div class="edit-members content p-2">
                <div class="add-new-member mt-2 mb-2">
                    <button
                        v-if="!newMemberForm"
                        @click="newMemberForm = !newMemberForm"
                        class="btn btn-primary text-center mb-2"
                    >
                        <i class="fas fa-user-plus"></i>
                        {{ lang.add_new_member }}
                    </button>

                    <form
                        @submit.prevent="getFormMethod()"
                        @keydown="form.onKeydown($event)"
                        v-if="newMemberForm"
                    >
                        <input
                            v-if="form.member_id"
                            hidden
                            v-model="form.member_id"
                            type="text"
                            name="member_id"
                        />

                        <input
                            hidden
                            v-model="form.store_id"
                            type="text"
                            name="store_id"
                        />

                        <input
                            v-model="form.email"
                            type="email"
                            name="email"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.en_member_email"
                        />
                        <small class="text-danger bold">
                            {{ lang.the_email_that }}
                        </small>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('email')"
                            v-html="form.errors.get('email')"
                        />

                        <div class="form-group mt-2">
                            <label for="employment">{{
                                lang.employment
                            }}</label>
                            <select
                                id="employment"
                                class="form-control"
                                v-model="form.position"
                            >
                                <option value="0">{{ lang.manager }}</option>
                                <option value="1">{{ lang.casher }}</option>
                                <option value="2">{{ lang.restaurant }}</option>
                                <option value="3">{{ lang.supervisor }}</option>
                            </select>
                        </div>

                        <div class="card mt-3">
                            <h5 class="card-header bold">
                                <i class="fas fa-user-gear"></i>
                                {{ lang.user_permissions }}
                            </h5>
                            <div class="card-body">
                                <div class="card row invoice-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.invoice_sett }}
                                        <div :class="getFloatPosition()">
                                            <input
                                                id="invoice-all"
                                                type="checkbox"
                                                name="invoice"
                                                v-model="form.invoice"
                                                @change="
                                                    form.invoice = [1, 2, 3, 4]
                                                "
                                            />
                                            <label for="invoice-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <!-- <input
                                                id="invoice-show"
                                                type="checkbox"
                                                name="invoice"
                                                value="0"
                                                v-model="form.invoice"
                                                checked
                                                hidden
                                            /> -->

                                        <div class="col-md-3">
                                            <input
                                                id="invoice-show"
                                                type="checkbox"
                                                name="invoice"
                                                value="1"
                                                v-model="form.invoice"
                                            />
                                            <label for="invoice-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="invoice-add"
                                                type="checkbox"
                                                name="invoice"
                                                value="2"
                                                v-model="form.invoice"
                                            />
                                            <label for="invoice-add">
                                                {{ lang.add_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="invoice-edit"
                                                type="checkbox"
                                                name="invoice"
                                                value="3"
                                                v-model="form.invoice"
                                            />
                                            <label for="invoice-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="invoice-delete"
                                                type="checkbox"
                                                name="invoice"
                                                value="4"
                                                v-model="form.invoice"
                                            />
                                            <label for="invoice-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Invoice Box  -->

                                <div class="card row section-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.section_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="section-all"
                                                type="checkbox"
                                                name="section"
                                                v-model="form.section"
                                                @change="
                                                    form.section = [1, 2, 3, 4]
                                                "
                                            />
                                            <label for="section-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="section-show"
                                                type="checkbox"
                                                name="section"
                                                value="1"
                                                v-model="form.section"
                                            />
                                            <label for="section-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="section-add"
                                                type="checkbox"
                                                name="section"
                                                value="2"
                                                v-model="form.section"
                                            />
                                            <label for="section-add">
                                                {{ lang.add_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="section-edit"
                                                type="checkbox"
                                                name="section"
                                                value="3"
                                                v-model="form.section"
                                            />
                                            <label for="section-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="section-delete"
                                                type="checkbox"
                                                name="section"
                                                value="4"
                                                v-model="form.section"
                                            />
                                            <label for="section-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Section Box  -->

                                <div class="card row product-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.product_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="product-all"
                                                type="checkbox"
                                                name="product"
                                                v-model="form.product"
                                                @change="
                                                    form.product = [1, 2, 3, 4]
                                                "
                                            />
                                            <label for="product-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="product-show"
                                                type="checkbox"
                                                name="product"
                                                value="1"
                                                v-model="form.product"
                                            />
                                            <label for="product-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="product-add"
                                                type="checkbox"
                                                name="product"
                                                value="2"
                                                v-model="form.product"
                                            />
                                            <label for="product-add">
                                                {{ lang.add_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="product-edit"
                                                type="checkbox"
                                                name="product"
                                                value="3"
                                                v-model="form.product"
                                            />
                                            <label for="product-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="product-delete"
                                                type="checkbox"
                                                name="product"
                                                value="4"
                                                v-model="form.product"
                                            />
                                            <label for="product-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Product Box  -->

                                <div class="card row table-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.table_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="table-all"
                                                type="checkbox"
                                                name="table"
                                                v-model="form.table"
                                                @change="
                                                    form.table = [1, 2, 3, 4]
                                                "
                                            />
                                            <label for="table-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="table-show"
                                                type="checkbox"
                                                name="table"
                                                value="1"
                                                v-model="form.table"
                                            />
                                            <label for="table-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="table-add"
                                                type="checkbox"
                                                name="table"
                                                value="2"
                                                v-model="form.table"
                                            />
                                            <label for="table-add">
                                                {{ lang.add_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="table-edit"
                                                type="checkbox"
                                                name="table"
                                                value="3"
                                                v-model="form.table"
                                            />
                                            <label for="table-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="table-delete"
                                                type="checkbox"
                                                name="table"
                                                value="4"
                                                v-model="form.table"
                                            />
                                            <label for="table-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Table Box  -->

                                <div class="card row member-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.member_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="member-all"
                                                type="checkbox"
                                                name="member"
                                                v-model="form.member"
                                                @change="
                                                    form.member = [1, 2, 3, 4]
                                                "
                                            />
                                            <label for="member-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="member-show"
                                                type="checkbox"
                                                name="member"
                                                value="1"
                                                v-model="form.member"
                                            />
                                            <label for="member-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="member-add"
                                                type="checkbox"
                                                name="member"
                                                value="2"
                                                v-model="form.member"
                                            />
                                            <label for="member-add">
                                                {{ lang.add_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="member-edit"
                                                type="checkbox"
                                                name="member"
                                                value="3"
                                                v-model="form.member"
                                            />
                                            <label for="member-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="member-delete"
                                                type="checkbox"
                                                name="member"
                                                value="4"
                                                v-model="form.member"
                                            />
                                            <label for="member-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Member Box  -->

                                <div class="card row store-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.store_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="store-all"
                                                type="checkbox"
                                                name="store"
                                                v-model="form.store"
                                                @change="form.store = [1, 3]"
                                            />
                                            <label for="store-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="store-show"
                                                type="checkbox"
                                                name="store"
                                                value="1"
                                                v-model="form.store"
                                            />
                                            <label for="store-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="store-edit"
                                                type="checkbox"
                                                name="store"
                                                value="3"
                                                v-model="form.store"
                                            />
                                            <label for="store-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Store Box  -->

                                <div class="card row history-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.black_box_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="history-show"
                                                type="checkbox"
                                                name="history"
                                                value="1"
                                                v-model="form.history"
                                            />
                                            <label for="history-show">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="history-show"
                                                type="checkbox"
                                                name="history"
                                                value="1"
                                                v-model="form.history"
                                            />
                                            <label for="history-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX History Box  -->

                                <div class="card row menu-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.menu_sett }}

                                        <div :class="getFloatPosition()">
                                            <input
                                                id="menu-all"
                                                type="checkbox"
                                                name="menu"
                                                v-model="form.menu"
                                                @change="form.menu = [1, 3]"
                                            />
                                            <label for="menu-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div>
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="menu-show"
                                                type="checkbox"
                                                name="menu"
                                                value="1"
                                                v-model="form.menu"
                                            />
                                            <label for="menu-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="menu-edit"
                                                type="checkbox"
                                                name="menu"
                                                value="3"
                                                v-model="form.menu"
                                            />
                                            <label for="menu-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Menu Box  -->
                            </div>
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
                                <span v-if="form.member_id">
                                    <i
                                        class="fas fa-edit mt-2 ml-2"
                                        :hidden="form.busy"
                                    ></i>
                                    {{ lang.edit_member }}
                                </span>
                                <span v-else>
                                    <i
                                        class="fas fa-plus mt-2 ml-2"
                                        :hidden="form.busy"
                                    ></i>
                                    {{ lang.add_member }}
                                </span>
                            </button>

                            <button
                                @click.prevent="cancelMethod()"
                                class="btn btn-light text-danger bold"
                            >
                                <i class="fas fa-times mt-2 ml-2"></i>
                                {{ lang.cancel }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="clear"></div>
                <!-- End Form Add New Member -->
                <div
                    style="max-height: 400px; overflow: auto"
                    class="curret-members-table mt-2"
                    v-if="!newMemberForm"
                >
                    <table class="table table-hover table-striped table-dark">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">{{ lang.name }}</th>
                                <th scope="col">{{ lang.email }}</th>
                                <th scope="col">{{ lang.position }}</th>
                                <th scope="col">{{ lang.edit }}</th>
                                <th scope="col">{{ lang.delete }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="text-center"
                                v-for="(member, index) in members"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ member.getmember.name }}</td>
                                <td>{{ member.getmember.email }}</td>
                                <td>
                                    <span v-if="member.position == 0">{{
                                        lang.manager
                                    }}</span>
                                    <span v-if="member.position == 1">{{
                                        lang.casher
                                    }}</span>
                                    <span v-if="member.position == 2">{{
                                        lang.restaurant
                                    }}</span>
                                    <span v-if="member.position == 3">{{
                                        lang.supervisor
                                    }}</span>
                                </td>
                                <td>
                                    <router-link
                                        :to="
                                            '?edit_member_id=' +
                                            member.getmember.id
                                        "
                                    >
                                        <i
                                            class="fas fa-edit btn btn-success"
                                        ></i
                                    ></router-link>
                                </td>
                                <td>
                                    <a
                                        href="#"
                                        @click="
                                            handleClick(member.getmember.id)
                                        "
                                    >
                                        <i
                                            class="fas fa-trash-alt btn btn-danger"
                                        ></i
                                    ></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "EditMembers",
    components: {},
    data: function () {
        return {
            newMemberForm: false,
            store_id: this.$parent.store_id,
            members: {},
            member: {},
            lang: this.$parent.lang,
            form: new Form({
                invoice: [],
                section: [],
                member: [],
                product: [],
                box: [],
                table: [],
                store: [],
                history: [],
                menu: [],
                email: "",
                member_id: null,
                position: 3,
                store_id: this.$parent.store_id,
            }),
            locale: "",
        };
    },
    mounted() {
        this.getmembers();
        this.formEmpty();
        this.urlReplace();
        this.locale = this.getLocale();
    },
    watch: {
        $route: function () {
            if (this.$route.query.edit_member_id) {
                this.form.member_id = this.$route.query.edit_member_id;
                this.newMemberForm = !this.newMemberForm;
                this.getMember(this.$route.query.edit_member_id, this.store_id);
            }
        },
        member: function () {
            this.form.email = this.member.getmember.email;
            this.form.position = this.member.position;
            this.form.store_id = this.member.store_id;
            this.form.invoice = this.member.invoice;
            this.form.section = this.member.section;
            this.form.product = this.member.product;
            this.form.table = this.member.table;
            this.form.member = this.member.member;
            this.form.store = this.member.store;
            this.form.menu = this.member.menu;
            this.form.history = this.member.history;
            this.form.box = this.member.box;
        },
    },
    methods: {
        editmembersToggle: function () {
            this.$parent.editmembers = !this.$parent.editmembers;
        },
        getFormMethod: function () {
            if (this.$route.query.edit_member_id)
                this.updateMember(this.$route.query.edit_member_id);
            else this.addNewMember();
        },
        cancelMethod: function () {
            this.newMemberForm = !this.newMemberForm;
            this.formEmpty();
            this.urlReplace();
        },
        async addNewMember() {
            const response = await this.form
                .post("/api/addnewmember")
                .then((res) => {
                    // console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.member_add_succ
                    );
                    this.formEmpty();
                    this.urlReplace();
                    this.newMemberForm = !this.newMemberForm;
                    this.getmembers();
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.verify_data
                    );
                });
        },
        async updateMember(edit_member_id) {
            const response = await this.form
                .post("/api/editmember")
                .then((res) => {
                    this.notification(
                        getType("success"),
                        this.lang.success,
                        this.lang.data_modified
                    );
                    // console.log(res.data);
                    this.formEmpty();
                    this.urlReplace();
                    this.newMemberForm = !this.newMemberForm;
                    this.getmembers();
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.verify_data
                    );
                });
        },
        getmembers: function () {
            axios
                .get(`/api/getmembers?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res);
                    this.members = res.data;
                })
                .catch((err) => {
                    // console.log(err)
                });
        },
        getMember: function (member_id, store_id) {
            axios
                .get(
                    `/api/getmember?member_id=${member_id}&store_id=${store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.member = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        deletemember: function (member_id, store_id) {
            axios
                .get(
                    `/api/deletemember?member_id=${member_id}&store_id=${store_id}`
                )
                .then((res) => {
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.employee_deleted
                    );
                    this.getmembers();
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.erroring_member_delete
                    );
                });
        },
        handleClick: function (member_id) {
            this.$confirm({
                auth: true,
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm, password) => {
                    if (confirm && password == "1234") {
                        this.deletemember(member_id, this.store_id);
                    }
                },
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
        formEmpty: function () {
            this.form.reset();
        },
        urlReplace: function () {
            if (this.$route.query) {
                this.$router
                    .replace({
                        path: this.$route.path,
                    })
                    .catch(() => {});
            }
        },
        getFloatPosition: function () {
            if (this.locale == "ar") {
                return "float-start";
            } else {
                return "float-end";
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
