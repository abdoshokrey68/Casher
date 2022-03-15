<template>
    <div id="store-audience" class="col-md-7 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="store-audience-header">
                <button
                    @click="storeHistoryToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-users mr-2 ml-2"></i>
                    {{ lang.store_audience }}
                </h2>
            </div>
            <div class="col-md-12 p-2">
                <a
                    href="#"
                    @click="handleClick(0)"
                    :class="'btn btn-danger col-md-4 bold float-start'"
                >
                    <i class="fas fa-trash-alt mr-2 ml-2"></i>
                    {{ lang.delete_all }}
                </a>
            </div>
            <!-- End Store Audience Header -->
            <div class="store-audience content p-2">
                <div
                    style="max-height: 400px; overflow: auto"
                    class="curret-audience-table mt-2"
                >
                    <table class="table table-hover table-striped table-light">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">{{ lang.phone }}</th>
                                <th scope="col">
                                    <i class="fas fa-trash-alt"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="text-center"
                                v-for="(audience, index) in audiences"
                                :key="index"
                            >
                                <td class="text-center">
                                    {{ index + 1 }}
                                </td>
                                <td class="text-center">
                                    {{ audience.phone }}
                                </td>
                                <td class="text-center">
                                    <a
                                        href="#"
                                        @click="handleClick(audience.id)"
                                    >
                                        <i
                                            class="fas fa-trash-alt btn btn-danger"
                                        ></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div v-if="!audiences.length" class="col-md-8 m-auto">
                            <h6 class="text-center text-danger h6">
                                {{ lang.no_audience }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "StoreHistory",
    components: {},
    data: function () {
        return {
            store_id: this.$parent.store_id,
            audiences: {},
            lang: this.$parent.lang,
            locale: "en",
        };
    },
    mounted() {
        this.locale = this.getLocale();
        this.getAudience(this.store_id);
    },
    methods: {
        storeHistoryToggle: function () {
            this.$parent.storehistory = !this.$parent.storehistory;
        },
        getAudience: function (store_id) {
            axios
                .post(`/api/audience/get?store_id=${store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.audiences = res.data;
                })
                .catch((err) => {
                    {
                        // console.log(err)
                    }
                });
        },
        deleteAudience: function (store_id, audience_id) {
            axios
                .post(
                    `/api/audience/delete?store_id=${store_id}&audience_id=${audience_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.getAudience(this.store_id);
                })
                .catch((err) => {
                    {
                        // console.log(err)
                    }
                });
        },
        handleClick: function (audience_id) {
            this.$confirm({
                message: `Are you sure?`,
                button: {
                    no: "No",
                    yes: "Yes",
                },
                callback: (confirm) => {
                    if (confirm) {
                        this.deleteAudience(this.store_id, audience_id);
                    }
                },
            });
        },
    },
};
</script>
