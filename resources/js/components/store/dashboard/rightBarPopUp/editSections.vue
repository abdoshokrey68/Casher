<template>
    <div id="edit-sections" class="col-md-6 section_id-auto">
        <div class="card justify-center border-warning border-2">
            <div class="edit-sections-header">
                <button
                    @click="editsectionsToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    Store Sections
                </h2>
            </div>
            <!-- End Edit Secitons Header -->
            <div class="edit-section content p-2">
                <div>
                    <button
                        v-if="!NewSectionFrom"
                        @click="NewSectionFrom = !NewSectionFrom"
                        class="btn btn-primary col-md-5 mb-2 mt-2"
                    >
                        <i class="fas fa-plus mr-2 ml-2"></i>
                        Add New Section
                    </button>
                    <form
                        @submit.prevent="getFormMethod(form.section_id)"
                        @keydown="form.onKeydown($event)"
                        v-if="NewSectionFrom"
                    >
                        <input
                            v-if="form.section_id"
                            hidden
                            v-model="form.section_id"
                            type="text"
                            name="section_id"
                        />

                        <input
                            hidden
                            v-model="form.store_id"
                            type="text"
                            name="store_id"
                        />

                        <input
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="form-control mt-2 mb-2"
                            placeholder="Name"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('name')"
                            v-html="form.errors.get('name')"
                        />

                        <textarea
                            v-model="form.description"
                            name="description"
                            class="form-control mt-2 mb-2"
                            placeholder="Description"
                        ></textarea>
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('description')"
                            v-html="form.errors.get('description')"
                        />

                        <input
                            v-model="form.discount"
                            type="number"
                            name="discount"
                            class="form-control mt-2 mb-2"
                            placeholder="Discount"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('discount')"
                            v-html="form.errors.get('discount')"
                        />
                        <div class="section-icon">
                            <label for=""
                                >Select Section Icon (Optional)
                            </label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-utensils"
                                        v-model="form.icon"
                                        id="fa-utensils"
                                    />
                                    <label for="fa-utensils"
                                        ><i
                                            class="fas fa-utensils fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-hamburger"
                                        v-model="form.icon"
                                        id="fa-hamburger"
                                    />
                                    <label for="fa-hamburger"
                                        ><i
                                            class="fas fa-hamburger fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>

                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-pizza-slice"
                                        v-model="form.icon"
                                        id="fa-pizza-slice"
                                    />
                                    <label for="fa-pizza-slice"
                                        ><i
                                            class="fas fa-pizza-slice fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-ice-cream"
                                        v-model="form.icon"
                                        id="fa-ice-cream"
                                    />
                                    <label for="fa-ice-cream"
                                        ><i
                                            class="fas fa-ice-cream fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-hotdog"
                                        v-model="form.icon"
                                        id="fa-hotdog"
                                    />
                                    <label for="fa-hotdog"
                                        ><i
                                            class="fas fa-hotdog fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-fish"
                                        v-model="form.icon"
                                        id="fa-fish"
                                    />
                                    <label for="fa-fish"
                                        ><i
                                            class="fas fa-fish fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-cheese"
                                        v-model="form.icon"
                                        id="fa-cheese"
                                    />
                                    <label for="fa-cheese"
                                        ><i
                                            class="fas fa-cheese fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-drumstick-bite"
                                        v-model="form.icon"
                                        id="fa-drumstick-bite"
                                    />
                                    <label for="fa-drumstick-bite"
                                        ><i
                                            class="fas fa-drumstick-bite fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-mug-hot"
                                        v-model="form.icon"
                                        id="fa-mug-hot"
                                    />
                                    <label for="fa-mug-hot"
                                        ><i
                                            class="fas fa-mug-hot fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-coffee"
                                        v-model="form.icon"
                                        id="fa-coffee"
                                    />
                                    <label for="fa-coffee"
                                        ><i
                                            class="fas fa-coffee fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-cocktail"
                                        v-model="form.icon"
                                        id="fa-cocktail"
                                    />
                                    <label for="fa-cocktail"
                                        ><i
                                            class="fas fa-cocktail fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-beer"
                                        v-model="form.icon"
                                        id="fa-beer"
                                    />
                                    <label for="fa-beer"
                                        ><i
                                            class="fas fa-beer fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-tshirt"
                                        v-model="form.icon"
                                        id="fa-tshirt"
                                    />
                                    <label for="fa-tshirt"
                                        ><i
                                            class="fas fa-tshirt fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-mitten"
                                        v-model="form.icon"
                                        id="fa-mitten"
                                    />
                                    <label for="fa-mitten"
                                        ><i
                                            class="fas fa-mitten fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-socks"
                                        v-model="form.icon"
                                        id="fa-socks"
                                    />
                                    <label for="fa-socks"
                                        ><i
                                            class="fas fa-socks fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-user-tie"
                                        v-model="form.icon"
                                        id="fa-user-tie"
                                    />
                                    <label for="fa-user-tie"
                                        ><i
                                            class="fas fa-user-tie fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-hat-cowboy-side"
                                        v-model="form.icon"
                                        id="fa-hat-cowboy-side"
                                    />
                                    <label for="fa-hat-cowboy-side"
                                        ><i
                                            class="fas fa-hat-cowboy-side fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                                <div class="col-md-3">
                                    <input
                                        type="radio"
                                        name="icon"
                                        value="fas fa-hat-cowboy"
                                        v-model="form.icon"
                                        id="fa-hat-cowboy"
                                    />
                                    <label for="fa-hat-cowboy"
                                        ><i
                                            class="fas fa-hat-cowboy fa-2x mr-2 ml-2"
                                        ></i
                                    ></label>
                                </div>
                            </div>
                            <small class="text-warning bold">
                                This icon will appear in the menu</small
                            >
                        </div>

                        <input
                            v-model="form.icon"
                            type="number"
                            name="icon"
                            class="form-control mt-2 mb-2"
                            placeholder="Discount"
                        />
                        <div
                            class="text-danger bold"
                            v-if="form.errors.has('icon')"
                            v-html="form.errors.get('icon')"
                        />

                        <div class="float-end">
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
                                <span v-if="form.section_id">
                                    <i
                                        class="fas fa-edit mt-2 ml-2"
                                        :hidden="form.busy"
                                    ></i>
                                    Edit Section</span
                                >
                                <span v-else>
                                    <i
                                        class="fas fa-plus mt-2 ml-2"
                                        :hidden="form.busy"
                                    ></i>
                                    Add Section</span
                                >
                            </button>

                            <button
                                @click.prevent="cancelMethod()"
                                class="btn btn-light text-danger bold"
                            >
                                <i class="fas fa-times mt-2 ml-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                    <div class="clear"></div>
                    <!-- End Form Add new section -->
                    <div class="old-sections" v-if="!NewSectionFrom">
                        <label for="search-sections">Search in Sections</label>
                        <input
                            type="text"
                            name="search-sections"
                            id="search-sections"
                            class="form-control"
                            v-model="sectionSearch"
                        />
                        <div
                            style="max-height: 400px; overflow: auto"
                            class="curret-section-table mt-2"
                        >
                            <table
                                class="table table-hover table-striped table-dark"
                            >
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(section, index) in sections"
                                    >
                                        <tr :key="index" class="text-center">
                                            <td>{{ section.name }}</td>
                                            <td>{{ section.discount }}</td>
                                            <td>
                                                <i
                                                    :class="
                                                        section.icon +
                                                        ' fa-2x text-light'
                                                    "
                                                ></i>
                                            </td>
                                            <td class="bold">
                                                <router-link
                                                    :to="
                                                        '?edit_section_id=' +
                                                        section.id
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit btn btn-success"
                                                    ></i>
                                                </router-link>
                                            </td>
                                            <td class="bold">
                                                <a
                                                    href="#"
                                                    @click="
                                                        handleClick(section.id)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-trash-alt btn btn-danger"
                                                    ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
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
    name: "editSections",
    components: {},
    data: function () {
        return {
            NewSectionFrom: false,
            form: new Form({
                name: "",
                description: "",
                discount: 0,
                icon: null,
                store_id: this.$parent.store_id,
                section_id: null,
            }),
            store_id: this.$parent.store_id,
            sections: {},
            sectionSearch: null,
            section: {},
            currentPath: null,
        };
    },
    mounted() {
        this.getSections();
        this.currentPath = this.$route.path;
    },
    watch: {
        $route: function () {
            if (this.$route.query.edit_section_id) {
                this.NewSectionFrom = !this.NewSectionFrom;
                this.getSection(this.$route.query.edit_section_id);
            }
        },
        section: function () {
            this.form.section_id = this.section.id;
            this.form.name = this.section.name;
            this.form.description = this.section.description;
            this.form.discount = this.section.discount;
        },
    },
    methods: {
        getFormMethod: function (section_id) {
            if (section_id) {
                this.updateSection();
            } else {
                this.createNewSection();
            }
        },
        async createNewSection() {
            const response = await this.form
                .post("/api/createnewsection")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Section added successfully"
                    );
                    this.form.reset();
                    this.NewSectionFrom = !this.NewSectionFrom;
                    this.getSections();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async updateSection() {
            const response = await this.form
                .post("/api/updatesection")
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Section Updated Successfully"
                    );
                    console.log(res);
                    this.form.reset();
                    this.NewSectionFrom = !this.NewSectionFrom;
                    this.$router.replace({
                        path: this.currentPath,
                    });
                    this.getSections();
                })
                .catch((err) => {
                    this.notification(
                        "warn",
                        "Warning",
                        "Warning To Updated Sections"
                    );
                    console.log(err);
                });
        },
        editsectionsToggle: function () {
            this.$parent.editsections = !this.$parent.editsections;
        },
        getSections() {
            axios
                .get(`/api/getsections?store_id=${this.store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.sections = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getSection(section_id) {
            axios
                .get(`/api/getsection?section_id=${section_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.section = res.data;
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
        handleClick: function (section_id) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        this.deleteSection(section_id);
                    }
                },
            });
        },
        deleteSection: function (section_id) {
            axios
                .get(`/api/deletesection?section_id=${section_id}`)
                .then((res) => {
                    this.notification(
                        "success",
                        "Success",
                        "Section has been deleted successfully"
                    );
                    this.getSections();
                });
        },
        cancelMethod: function () {
            this.NewSectionFrom = !this.NewSectionFrom;
            this.form.reset();
            if (this.form.section_id) {
                this.form.section_id = null;
            }
            this.urlReplace();
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
