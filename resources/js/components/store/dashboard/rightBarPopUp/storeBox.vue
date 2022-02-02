<template>
    <div id="pay-invoice" class="col-md-3 m-auto">
        <div class="card justify-center border-warning border-2">
            <div class="pay-invoice-header m-2">
                <button
                    @click="storeBoxToggle()"
                    class="float-end btn btn-light m-1 mt-2"
                >
                    <i class="fas fa-times fa-2x"></i>
                </button>
            </div>
            <div class="col-md-12 p-2">
                <a href="#" class="btn btn-primary col-md-12 p-2">
                    The Amount delivered
                </a>
                <a
                    href="#"
                    class="btn btn-secondary col-md-12 p-2 mt-2 disabled"
                >
                    Received Amount
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PayInvoice",
    components: {},
    data: function () {
        return {};
    },
    methods: {
        storeBoxToggle: function () {
            this.$parent.storebox = !this.$parent.storebox;
        },
    },
};
</script>
