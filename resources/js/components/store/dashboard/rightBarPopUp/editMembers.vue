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
                    <i class="fas fa-users-cog"></i> User Management
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
                        <i class="fas fa-user-plus"></i> Add New Member
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
                            placeholder="Enter Member Email"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('email')"
                            v-html="form.errors.get('email')"
                        />

                        <div class="form-group mt-2">
                            <label for="employment">Employment</label>
                            <select
                                id="employment"
                                class="form-control"
                                v-model="form.position"
                            >
                                <option value="0">Manager</option>
                                <option value="1">Casher</option>
                                <option value="2">Restaurant</option>
                                <option value="3">Admin</option>
                            </select>
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
                                Add Member
                            </button>

                            <button
                                @click.prevent="cancelMethod()"
                                class="btn btn-light text-danger bold"
                            >
                                <i class="fas fa-times mt-2 ml-2"></i> Cancel
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
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Position</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="text-center"
                                v-for="(member, index) in members"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ member.name }}</td>
                                <td>{{ member.email }}</td>
                                <td>
                                    <span v-if="member.position == 0"
                                        >Manager</span
                                    >
                                    <span v-if="member.position == 1"
                                        >Casher</span
                                    >
                                    <span v-if="member.position == 2"
                                        >Restaurant</span
                                    >
                                    <span v-if="member.position == 3"
                                        >Admin</span
                                    >
                                </td>
                                <td>
                                    <router-link
                                        :to="'?edit_member_id=' + member.id"
                                    >
                                        <i
                                            class="fas fa-edit btn btn-success"
                                        ></i
                                    ></router-link>
                                </td>
                                <td>
                                    <a href="#" @click="handleClick(member.id)">
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
            buttonloading: false,
            newMemberForm: false,
            store_id: this.$parent.store_id,
            members: {},
            member: {},
            form: new Form({
                email: "",
                member_id: null,
                position: 3,
                store_id: this.$parent.store_id,
            }),
        };
    },
    mounted() {
        this.getmembers();
        this.formEmpty();
        this.urlReplace();
    },
    watch: {
        $route: function () {
            if (this.$route.query.edit_member_id) {
                this.form.member_id = this.$route.query.edit_member_id;
                this.newMemberForm = !this.newMemberForm;
                this.getMember(this.$route.query.edit_member_id);
            }
        },
        member: function () {
            this.form.email = this.member.email;
            this.form.position = this.member.position;
            this.form.store_id = this.member.store_id;
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
            this.buttonloading = !this.buttonloading;
            const response = await this.form
                .post("/api/addnewmember")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Member added successfully"
                    );
                    this.formEmpty();
                    this.urlReplace();
                    this.buttonloading = !this.buttonloading;
                    this.newMemberForm = !this.newMemberForm;
                    this.getmembers();
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        "error",
                        "Error",
                        "Verify that the e-mail is correct and the data is correct"
                    );
                    this.buttonloading = !this.buttonloading;
                });
        },
        async updateMember(edit_member_id) {
            this.buttonloading = !this.buttonloading;
            const response = await this.form
                .post("/api/editmember")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "The data has been modified successfully"
                    );
                    this.formEmpty();
                    this.urlReplace();
                    this.buttonloading = !this.buttonloading;
                    this.newMemberForm = !this.newMemberForm;
                    this.getmembers();
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        "error",
                        "Error",
                        "Verify that the e-mail is correct and the data is correct"
                    );
                    this.buttonloading = !this.buttonloading;
                });
        },
        getmembers: function () {
            axios
                .get(`/api/getmembers?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res);
                    this.members = res.data;
                })
                .catch((err) => console.log(err));
        },
        getMember: function (member_id) {
            axios
                .get(`/api/getmember?member_id=${member_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.member = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deletemember: function (member_id) {
            axios
                .get(`/api/deletemember?member_id=${member_id}`)
                .then((res) => {
                    this.notification(
                        "success",
                        "Success ",
                        "An employee has been successfully deleted"
                    );
                    this.getmembers();
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        "error",
                        "Error",
                        "Erroring To Deleted Member"
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
                        this.deletemember(member_id);
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
    },
};
</script>
