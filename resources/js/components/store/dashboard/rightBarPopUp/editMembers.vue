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
                <div
                    v-if="position.member_add"
                    class="add-new-member mt-2 mb-2"
                >
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
                            v-model="form.email"
                            type="email"
                            name="email"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.en_member_email"
                            :disabled="form.member_id"
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
                                <option value="4">
                                    {{ lang.Marketing_Specialist }}
                                </option>
                                <option value="5">
                                    {{ lang.Data_Analyst }}
                                </option>
                                <option value="6">
                                    {{ lang.Administrative_Manager }}
                                </option>
                                <option value="7">
                                    {{ lang.Sales_Manager }}
                                </option>
                                <option value="8">
                                    {{ lang.Inventory_Manager }}
                                </option>
                                <option value="9">
                                    {{ lang.Financial_Controller }}
                                </option>
                            </select>
                            <div
                                v-if="form.position == '2'"
                                class="text-danger bold"
                            >
                                {{ lang.Restaurant_service_is_not_currently }}
                            </div>
                            <div
                                class="text-danger bold"
                                v-if="form.errors.has('position')"
                                v-html="form.errors.get('position')"
                            />
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
                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="invoice-all"
                                                type="checkbox"
                                                name="invoice"
                                                @change="selectAll($event)"
                                            />
                                            <label for="invoice-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="invoice-show"
                                                type="checkbox"
                                                name="invoice"
                                                v-model="form.invoice_show"
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
                                                v-model="form.invoice_add"
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
                                                v-model="form.invoice_edit"
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
                                                v-model="form.invoice_delete"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="section-all"
                                                type="checkbox"
                                                name="section"
                                                @change="selectAll($event)"
                                            />
                                            <label for="section-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="section-show"
                                                type="checkbox"
                                                name="section"
                                                v-model="form.section_show"
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
                                                v-model="form.section_add"
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
                                                v-model="form.section_edit"
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
                                                v-model="form.section_delete"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="product-all"
                                                type="checkbox"
                                                name="product"
                                                @change="selectAll($event)"
                                            />
                                            <label for="product-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="product-show"
                                                type="checkbox"
                                                name="product"
                                                v-model="form.product_show"
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
                                                v-model="form.product_add"
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
                                                v-model="form.product_edit"
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
                                                v-model="form.product_delete"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="table-all"
                                                type="checkbox"
                                                name="table"
                                                @change="selectAll($event)"
                                            />
                                            <label for="table-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="table-show"
                                                type="checkbox"
                                                name="table"
                                                v-model="form.table_show"
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
                                                v-model="form.table_add"
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
                                                v-model="form.table_edit"
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
                                                v-model="form.table_delete"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="member-all"
                                                type="checkbox"
                                                name="member"
                                                @change="selectAll($event)"
                                            />
                                            <label for="member-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="member-show"
                                                type="checkbox"
                                                name="member"
                                                v-model="form.member_show"
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
                                                v-model="form.member_add"
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
                                                v-model="form.member_edit"
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
                                                v-model="form.member_delete"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="store-all"
                                                type="checkbox"
                                                name="store"
                                                @change="selectAll($event)"
                                            />
                                            <label for="store-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="store-edit"
                                                type="checkbox"
                                                name="store"
                                                v-model="form.store_edit"
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

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="history-show"
                                                type="checkbox"
                                                name="history"
                                                @change="selectAll($event)"
                                            />
                                            <label for="history-show">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="history-show"
                                                type="checkbox"
                                                name="history"
                                                v-model="form.history_show"
                                            />
                                            <label for="history-show">
                                                {{ lang.show_u }}
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input
                                                id="history-delete"
                                                type="checkbox"
                                                name="history"
                                                v-model="form.history_delete"
                                            />
                                            <label for="history-delete">
                                                {{ lang.delete_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX History Box  -->

                                <div class="card row menu-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.menu_sett }}

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="menu-all"
                                                type="checkbox"
                                                name="menu"
                                                @change="selectAll($event)"
                                            />
                                            <label for="menu-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="menu-edit"
                                                type="checkbox"
                                                name="menu"
                                                v-model="form.menu_edit"
                                            />
                                            <label for="menu-edit">
                                                {{ lang.edit_u }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Menu Box  -->

                                <div class="card row store-box mb-2">
                                    <h6 class="card-header bold p-3">
                                        {{ lang.box_sett }}

                                        <!-- <div :class="getFloatPosition()">
                                            <input
                                                id="box-all"
                                                type="checkbox"
                                                name="box"
                                                @change="selectAll($event)"
                                            />
                                            <label for="box-all">
                                                {{ lang.select_all_u }}
                                            </label>
                                        </div> -->
                                    </h6>
                                    <div class="row card-body">
                                        <div class="col-md-3">
                                            <input
                                                id="box-add"
                                                type="checkbox"
                                                name="box"
                                                v-model="form.box_add"
                                            />
                                            <label for="box-add">
                                                {{ lang.treasury_officer }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End CHECKBOX Store Box  -->
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
                <div v-if="position.member_show" class="show-member-box">
                    <div
                        style="max-height: 400px; overflow: auto"
                        class="curret-members-table mt-2"
                        v-if="!newMemberForm"
                    >
                        <table
                            class="table table-hover table-striped table-dark"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">{{ lang.name }}</th>
                                    <th scope="col">{{ lang.email }}</th>
                                    <th scope="col">{{ lang.position }}</th>
                                    <th v-if="position.member_edit" scope="col">
                                        {{ lang.edit }}
                                    </th>
                                    <th
                                        v-if="position.member_delete"
                                        scope="col"
                                    >
                                        {{ lang.delete }}
                                    </th>
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
                                        <span v-if="member.position == 4">
                                            {{ lang.Marketing_Specialist }}
                                        </span>
                                        <span v-if="member.position == 5">
                                            {{ lang.Data_Analyst }}
                                        </span>
                                        <span v-if="member.position == 6">
                                            {{ lang.Administrative_Manager }}
                                        </span>
                                        <span v-if="member.position == 7">
                                            {{ lang.Sales_Manager }}
                                        </span>
                                        <span v-if="member.position == 8">
                                            {{ lang.Inventory_Manager }}
                                        </span>
                                        <span v-if="member.position == 9">
                                            {{ lang.Financial_Controller }}
                                        </span>
                                    </td>
                                    <td v-if="position.member_edit">
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
                                    <td v-if="position.member_delete">
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
                <!-- End show member box -->
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
                invoice_show: 0,
                invoice_add: 0,
                invoice_edit: 0,
                invoice_delete: 0,
                section_show: 0,
                section_add: 0,
                section_edit: 0,
                section_delete: 0,
                member_show: 0,
                member_add: 0,
                member_edit: 0,
                member_delete: 0,
                product_show: 0,
                product_add: 0,
                product_edit: 0,
                product_delete: 0,
                table_show: 0,
                table_add: 0,
                table_edit: 0,
                table_delete: 0,
                history_show: 0,
                history_delete: 0,
                menu_edit: 0,
                store_edit: 0,
                box_add: 0,
                email: "",
                member_id: null,
                position: 3,
                store_id: this.$parent.store_id,
            }),
            locale: "",
            position: {},
        };
    },
    mounted() {
        this.getPositions();
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
            this.form.store_id = this.store_id;
            this.form.invoice_show = this.member.invoice_show;
            this.form.invoice_add = this.member.invoice_add;
            this.form.invoice_edit = this.member.invoice_edit;
            this.form.invoice_delete = this.member.invoice_delete;
            this.form.section_show = this.member.section_show;
            this.form.section_add = this.member.section_add;
            this.form.section_edit = this.member.section_edit;
            this.form.section_delete = this.member.section_delete;
            this.form.member_show = this.member.member_show;
            this.form.member_add = this.member.member_add;
            this.form.member_edit = this.member.member_edit;
            this.form.member_delete = this.member.member_delete;
            this.form.product_show = this.member.product_show;
            this.form.product_add = this.member.product_add;
            this.form.product_edit = this.member.product_edit;
            this.form.product_delete = this.member.product_delete;
            this.form.table_show = this.member.table_show;
            this.form.table_add = this.member.table_add;
            this.form.table_edit = this.member.table_edit;
            this.form.table_delete = this.member.table_delete;
            this.form.history_show = this.member.history_show;
            this.form.history_delete = this.member.history_delete;
            this.form.menu_edit = this.member.menu_edit;
            this.form.store_edit = this.member.store_edit;
            this.form.box_add = this.member.box_add;
        },
    },
    methods: {
        editmembersToggle: function () {
            this.$parent.editmembers = !this.$parent.editmembers;
        },
        getFormMethod: function () {
            if (this.$route.query.edit_member_id)
                this.updateMember(this.member.member_id);
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
                    // console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_modified
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
        // selectAll: function (e) {
        //     if (e.target.checked == true) {
        //         let el = document.getElementsByName(e.target.name);
        //         for (let i = 1; i < el.length; i++) {
        //             console.log(el[i]);
        //             this.form.invoice + "_show" == false;
        //             el[i].checked = true;
        //         }
        //     } else {
        //         let el = document.getElementsByName(e.target.name);
        //         for (let i = 1; i < el.length; i++) {
        //             el[i].checked = false;
        //         }
        //     }
        // },
        getPositions: function () {
            axios
                .get(`/api/member/position?store_id=${this.store_id}`)
                .then((res) => {
                    this.position = res.data.position;
                })
                .catch((err) => {
                    // console.log(err);
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
