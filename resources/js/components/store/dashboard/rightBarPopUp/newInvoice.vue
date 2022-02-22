<template>
    <div id="new-invoice" class="col-md-7 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="new-invoice-header">
                <button
                    @click="newinvoiceToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="h4 text-center bg-d-blue text-light m-0 p-3">
                    {{ lang.select_table }}
                </h2>
            </div>
            <div class="card new-invoice-tabels">
                <div class="row" style="margin: inherit">
                    <div
                        class="col-md-4 mt-1 mb-1 action"
                        v-for="(table, index) in tables"
                        :key="index"
                    >
                        <router-link
                            :class="getClass(table.status)"
                            :to="
                                '?table_id=' +
                                table.id +
                                '&invoice_id=' +
                                table.status +
                                '&time=' +
                                time
                            "
                            tag="a"
                        >
                            {{ table.name }}
                            <small
                                v-if="table.status != 0"
                                class="text-warning bold"
                            >
                                "{{ lang.reserved }}"
                            </small>
                        </router-link>
                    </div>
                    <div class="col-md-4 mt-1 mb-1">
                        <router-link
                            class="p-3 btn btn-danger bold col-12 action"
                            :to="'?table_id=0&invoice_id=0&time=' + time"
                            tag="a"
                        >
                            <i class="fas fa-money-bill-wave"></i>
                            {{ lang.cash }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "newInvoice",
    data: function () {
        return {
            store_id: this.$parent.store_id,
            tables: {},
            time: "",
            lang: this.$parent.lang,
        };
    },
    mounted() {
        this.getTables();
        this.time = new Date().getTime();
    },
    methods: {
        getClass: function (status) {
            if (status == 0) {
                return "p-3 btn btn-light text-center bold col-12 action";
            } else {
                return "p-3 btn btn-light bg-d-blue text-light text-center bold col-12 action";
            }
        },
        newinvoiceToggle: function () {
            this.$parent.newinvoice = !this.$parent.newinvoice;
        },
        getTables: function () {
            axios
                .get(`/api/gettables?store_id=${this.store_id}`)
                .then((res) => {
                    this.tables = res.data;
                })
                .catch((err) => console.log(err));
        },
    },
};
</script>
