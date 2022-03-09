<template>
    <div id="edit-tables" class="col-md-6 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="edit-tables-header">
                <button
                    @click="editTablesToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.edit_section }}
                </h2>
            </div>
            <!-- End Edit Secitons Header -->
            <div class="edit-tables content p-2">
                <div>
                    <button
                        class="btn btn-primary col-md-4"
                        v-if="!tableForm"
                        @click="tableForm = !tableForm"
                    >
                        <i class="fas fa-plus mr-2 ml-2"></i>
                        {{ lang.add_new_table }}
                    </button>
                    <form
                        @submit.prevent="getFormMethod()"
                        @keydown="form.onKeydown($event)"
                        v-if="tableForm"
                    >
                        <input
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="form-control mt-2 mb-2"
                            :placeholder="lang.en_table_name"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
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
                                <span v-if="form.table_id">
                                    {{ lang.edit_table }}
                                </span>
                                <span v-else> {{ lang.add_table }} </span>
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
                    <!-- End Form Add new table -->
                    <div class="old-tables" v-if="!tableForm">
                        <h3 class="h5 bold mt-3">{{ lang.current_tables }}</h3>
                        <label for="search-tables">{{
                            lang.search_tables
                        }}</label>
                        <input
                            type="text"
                            name="search-tables"
                            id="search-tables"
                            class="form-control"
                            v-model="searchTables"
                        />
                        <div
                            style="max-height: 400px; overflow: auto"
                            class="curret-table-table mt-2"
                        >
                            <table
                                class="table table-hover table-striped table-dark mt-2"
                            >
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">{{ lang.name }}</th>
                                        <th scope="col">{{ lang.edit }}</th>
                                        <th scope="col">{{ lang.delete }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-center"
                                        v-for="(table, index) in tables"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ table.name }}</td>
                                        <td>
                                            <router-link
                                                :to="
                                                    '?edit_table_id=' + table.id
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
                                                @click="handleClick(table.id)"
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
        </div>
    </div>
</template>

<script>
import Form from "vform";

export default {
    name: "storeTables",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            tables: {},
            table: {},
            searchTables: null,
            tableForm: false,
            lang: this.$parent.lang,
            form: new Form({
                name: "",
                table_id: null,
                store_id: this.$parent.store_id,
            }),
            locale: "",
        };
    },
    mounted() {
        this.getTables();
        this.urlReplace();
        this.locale = this.getLocale();
    },
    watch: {
        $route: function () {
            if (this.$route.query.edit_table_id) {
                this.form.table_id = this.$route.query.edit_table_id;
                this.tableForm = !this.tableForm;
                this.getTable(this.$route.query.edit_table_id);
            }
        },
        table: function () {
            this.form.name = this.table.name;
        },
    },
    methods: {
        editTablesToggle: function () {
            this.$parent.edittables = !this.$parent.edittables;
        },
        getFormMethod: function () {
            if (this.$route.query.edit_table_id) {
                this.updateTable();
            } else {
                this.addNewTable();
            }
        },
        cancelMethod: function () {
            this.tableForm = !this.tableForm;
            this.formEmpty();
            this.urlReplace();
        },
        async addNewTable() {
            this.buttonloading = !this.buttonloading;
            const response = await this.form
                .post("/api/addtable")
                .then((res) => {
                    console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.add_success
                    );
                    this.tableForm = !this.tableForm;
                    this.buttonloading = !this.buttonloading;
                    this.formEmpty();
                    this.urlReplace();
                    this.getTables();
                })
                .catch((err) => {
                    this.buttonloading = !this.buttonloading;
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.there_seems_problem
                    );
                });
        },
        async updateTable() {
            this.buttonloading = !this.buttonloading;
            const response = await this.form
                .post("/api/updatetable")
                .then((res) => {
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.data_modified
                    );
                    this.tableForm = !this.tableForm;
                    this.formEmpty();
                    this.urlReplace();
                    this.buttonloading = !this.buttonloading;
                    this.getTables();
                })
                .catch((err) => {
                    this.buttonloading = !this.buttonloading;
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.there_seems_problem
                    );
                });
        },
        getTables: function () {
            axios
                .get(`/api/gettables?store_id=${this.store_id}`)
                .then((res) => {
                    this.tables = res.data;
                })
                .catch((err) => console.log(err));
        },
        getTable: function (table_id) {
            axios
                .get(
                    `/api/gettable?table_id=${table_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    this.table = res.data;
                })
                .catch((err) => console.log(err));
        },
        deleteTable: function (table_id) {
            axios
                .get(
                    `/api/deletetable?table_id=${table_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    console.log(res.data);
                    this.notification(
                        this.getType("success"),
                        this.lang.success,
                        this.lang.delete_success
                    );
                    this.getTables();
                })
                .catch((err) => {
                    console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.deleted_there_problem
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
        handleClick: function (table_id) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        this.deleteTable(table_id);
                    }
                },
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
