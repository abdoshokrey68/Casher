<template>
    <div id="store-sections">
        <div class="col-md-12 p-1 bg-d-blue text-light">
            <h5 class="text-center p-2 m-0 bold">Sections</h5>
        </div>
        <!-- End Store Section Header -->
        <div class="col-md-12 p-1">
            <div class="list-group">
                <router-link
                    tag="a"
                    :to="{
                        path: fullPath,
                        query: {
                            section: 0,
                            time: time,
                        },
                    }"
                    :class="getClass(0)"
                >
                    All Products
                </router-link>
                <div v-for="(section, index) in sections" :key="index">
                    <router-link
                        :to="{
                            path: fullPath,
                            query: {
                                section: section.id,
                                time: time,
                            },
                        }"
                        :class="getClass(section.id)"
                    >
                        {{ section.name }}
                    </router-link>
                </div>
            </div>
            <!-- End All Sections -->
        </div>
    </div>
</template>

<script>
export default {
    name: "storeSections",
    data: function () {
        return {
            store_id: this.$parent.store_id,
            sections: {},
            section_id: null,
            sectionName: null,
            sectionSelected: null,
            time: 0,
            fullPath: this.$route.path,
        };
    },
    watch: {
        $route(to, from) {
            if (this.$route.query.section) {
                this.sectionSelected = this.$route.query.section;
            }
            if (this.$route.query.invoice_id) {
                this.fullPath = this.$route.fullPath;
            }
            this.time = new Date().getTime();
        },
    },
    mounted() {
        this.getSections();
        this.time = new Date().getTime();
        this.urlReplace();
    },
    methods: {
        getClass(sec_id) {
            if (this.sectionSelected == sec_id) {
                return "list-group-item list-group-item-action text-center active mt-2 p-1";
            } else {
                return "list-group-item list-group-item-action text-center action mt-2 p-1";
            }
        },
        getSections() {
            axios
                .get(`/api/getsections?store_id=${this.store_id}`)
                .then((res) => {
                    this.sections = res.data;
                });
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
