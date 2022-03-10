<template>
    <div id="new-members" class="col-md-9 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-members-header">
                <button
                    @click="storeHistoryToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    <i class="fas fa-shield mr-2 ml-2"></i>
                    {{ lang.dark_box }}
                </h2>
            </div>
            <!-- End Edit Members Header -->
            <div class="edit-members content p-2">
                <div
                    style="max-height: 400px; overflow: auto"
                    class="curret-members-table mt-2"
                >
                    <table class="table table-hover table-striped table-light">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">{{ lang.des }}</th>
                                <th scope="col">{{ lang.email }}</th>
                                <th scope="col">{{ lang.from_n }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="text-center"
                                v-for="(history, index) in histories"
                                :key="index"
                            >
                                <td :class="getClass(history.status)">
                                    {{ index + 1 }}
                                </td>
                                <td :class="getClass(history.status)">
                                    {{ history.des }}
                                </td>
                                <td>{{ history.member.email }}</td>
                                <td>{{ history.from }}</td>
                            </tr>
                        </tbody>
                    </table>
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
            histories: {},
            lang: this.$parent.lang,
            locale: "en",
        };
    },
    mounted() {
        this.locale = this.getLocale();
        this.getHistory(this.store_id, this.locale);
    },
    methods: {
        storeHistoryToggle: function () {
            this.$parent.storehistory = !this.$parent.storehistory;
        },
        getHistory: function (store_id, locale) {
            axios
                .get(`/api/gethistory?store_id=${store_id}&locale=${locale}`)
                .then((res) => {
                    // console.log(res.data);
                    this.histories = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getClass: function (status) {
            if (status == 0) {
                return "text-center bold";
            } else {
                return "text-center";
            }
        },
    },
};
</script>
