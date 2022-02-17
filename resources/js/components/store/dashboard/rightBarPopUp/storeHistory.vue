<template>
    <div id="new-members" class="col-md-4 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-members-header">
                <button
                    @click="storeHistoryToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-history mr-2 ml-2"></i>
                    {{ lang.store_history }}
                </h2>
            </div>
            <!-- End Edit Members Header -->
            <div class="edit-members content p-2">
                <div
                    style="max-height: 400px; overflow: auto"
                    class="curret-members-table mt-2"
                >
                    <table class="table table-hover table-striped table-light">
                        <tbody>
                            <tr
                                class="text-center"
                                v-for="(member, index) in members"
                                :key="index"
                            >
                                <td>{{ member.name }}</td>
                                <td>{{ member.email }}</td>
                                <td>{{ member.id }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PayInvoice",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            members: {},
            lang: this.$parent.lang,
        };
    },
    mounted() {
        this.getmembers();
    },
    methods: {
        storeHistoryToggle: function () {
            this.$parent.storehistory = !this.$parent.storehistory;
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
    },
};
</script>
