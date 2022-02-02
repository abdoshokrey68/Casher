<template>
    <div>
        <nav class="navbar-light top-navbar p-2 pb-0">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="col-4 pr-1 pl-1 pt-2 text-center">
                                <p class="p-0 m-0">Invoice NO</p>
                            </div>
                            <div class="col-8 p-0">
                                <input
                                    type="text"
                                    class="form-control rounded text-light bg-d-blue border-0 text-center text-bold pt-sm-2"
                                    disabled
                                    :value="invoice_id"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="col-4 pr-1 pl-1 pt-2 text-center">
                                <p class="p-0 m-0">Table NO</p>
                            </div>
                            <div class="col-8 p-0">
                                <input
                                    type="text"
                                    class="form-control rounded text-light bg-d-blue border-0 text-center text-bold pt-sm-2"
                                    disabled
                                    :value="table_id"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="col text-center pt-2 pb-2">
                                <p class="p-0 m-0">{{ time }}</p>
                            </div>
                            <div class="col text-center pt-2 pb-2">
                                <p class="p-0 m-0">{{ date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "navigationBar",
    data() {
        return {
            time: null,
            date: null,
            table_id: 0,
            invoice_id: 0,
        };
    },
    mounted() {
        this.getDate();
        this.getTime();
    },
    watch: {
        $route: function () {
            if (this.$route.query.table_id) {
                if (this.$route.query.table_id != this.table_id) {
                    this.newinvoiceToggle();
                }
                this.table_id = this.$route.query.table_id;
            }
            if (this.$route.query.invoice_id) {
                this.invoice_id = this.$route.query.invoice_id;
            }
        },
    },
    methods: {
        newinvoiceToggle: function () {
            this.$parent.newinvoice = !this.$parent.newinvoice;
        },
        getDate() {
            const months = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            var date = new Date();
            var year = date.getFullYear();
            var monthCount = date.getMonth();
            var month = months[monthCount].substring(0, 3);
            var day = date.getDay();
            this.date = day + "-" + month + "-" + year;
        },
        getTime() {
            var time = new Date();
            var hour = time.getHours();
            var ampm = "AM";
            if (hour > 12) {
                hour -= 12;
                ampm = "PM";
            } else if (hour === 0) {
                hour = 12;
            }
            if (hour < 10) hour = "0" + hour;

            var min = time.getMinutes();

            this.time = hour + ":" + min + " " + ampm;
        },
    },
};
</script>
