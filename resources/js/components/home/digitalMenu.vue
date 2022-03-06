<template>
    <div id="casher-program-compo">
        <div
            class="casher-program-header"
            style="background-image: url('/image/home/qr-degital-menu.jpg')"
        >
            <div class="header-text col-md-4">
                <h1 class="h2">
                    {{ lang.luxurious_experience }}
                </h1>
                <a href="#" class="btn btn-warning col-md-12">
                    {{ lang.learn_more }}
                </a>
            </div>
        </div>
        <div class="the-benefits mt-5 mb-5">
            <div class="heading">
                <h3 class="h3">
                    {{ lang.dig_men }}
                </h3>
                <h6 class="col-5 m-auto h5 line-40">
                    {{ lang.Give_your_customers_a_safe }}
                </h6>
            </div>

            <div id="the-benefits-content" class="row mt-5 mb-5">
                <div class="col-md-12">
                    <div class="row b-0">
                        <div class="col-md-4 p-1 mt-2 mb-2 text-center bold">
                            <div class="bg-light p-5">
                                <i
                                    class="fas fa-hand-sparkles fa-4x text-warning m-3"
                                ></i>
                                <h3 class="h3 bold text-header text-warning">
                                    {{ lang.clean_and_safe }}
                                </h3>
                                <h4 class="h4 line-40">
                                    {{ lang.They_are_digital_to_ensure }}
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4 p-1 mt-2 mb-2 text-center bold">
                            <div class="bg-light p-5">
                                <i
                                    class="fas fa-minimize fa-4x text-warning m-3"
                                ></i>
                                <h3 class="h3 bold text-header text-warning">
                                    {{ lang.Compatible_with_all_mobile_phones }}
                                </h3>
                                <h4 class="h4 line-40">
                                    {{ lang.Responsive_and_clear_menu }}
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4 p-1 mt-2 mb-2 text-center bold">
                            <div class="bg-light p-5">
                                <i
                                    class="fas fa-hand-holding-dollar fa-4x text-warning m-3"
                                ></i>
                                <h3 class="h3 bold text-header text-warning">
                                    {{ lang.Cost_effective }}
                                </h3>
                                <h4 class="h4 line-40">
                                    {{ lang.Being_connected_to_the_store }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container features-digital-menu mt-5 mb-5">
            <div class="">
                <div class="row">
                    <div class="col-md-8 p-0 the-benefits">
                        <div class="heading">
                            <h3 class="h4">
                                {{ lang.Features_of_the_digital_menu }}
                            </h3>
                            <div class="row">
                                <div class="col-4 p-0">
                                    <div
                                        class="list-group"
                                        id="list-tab"
                                        role="tablist"
                                    >
                                        <a
                                            class="list-group-item list-group-item-action active"
                                            id="free-service-list"
                                            data-toggle="list"
                                            href="#free-service"
                                            role="tab"
                                            aria-controls="free service"
                                        >
                                            {{ lang.free_service }}
                                        </a>
                                        <a
                                            class="list-group-item list-group-item-action"
                                            id="save-money-list"
                                            data-toggle="list"
                                            href="#save-money"
                                            role="tab"
                                            aria-controls="save money"
                                            >{{ lang.save_money }}</a
                                        >
                                        <a
                                            class="list-group-item list-group-item-action"
                                            id="list-synchronous-list"
                                            data-toggle="list"
                                            href="#list-synchronous"
                                            role="tab"
                                            aria-controls="messages"
                                            >{{ lang.synchronous }}</a
                                        >
                                        <a
                                            class="list-group-item list-group-item-action"
                                            id="list-audience-list"
                                            data-toggle="list"
                                            href="#list-audience"
                                            role="tab"
                                            aria-controls="settings"
                                            >{{ lang.The_audience_menu }}</a
                                        >
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div
                                        class="tab-content"
                                        id="nav-tabContent"
                                    >
                                        <div
                                            class="tab-pane fade p-2 show active"
                                            id="free-service"
                                            role="tabpanel"
                                            aria-labelledby="free-service-list"
                                        >
                                            {{ lang.We_offer_you_the_free }}
                                        </div>
                                        <div
                                            class="tab-pane fade p-2"
                                            id="save-money"
                                            role="tabpanel"
                                            aria-labelledby="save-money-list"
                                        >
                                            {{
                                                lang.The_digital_menu_offers_you
                                            }}
                                        </div>
                                        <div
                                            class="tab-pane fade p-2"
                                            id="list-synchronous"
                                            role="tabpanel"
                                            aria-labelledby="list-synchronous-list"
                                        >
                                            {{ lang.digital_synchronous }}
                                        </div>
                                        <div
                                            class="tab-pane fade p-2"
                                            id="list-audience"
                                            role="tabpanel"
                                            aria-labelledby="list-audience-list"
                                        >
                                            {{ lang.It_allows_the_list_reader }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End heading Class -->
                    </div>
                    <!-- End col-md-6 Class -->
                    <div class="col-md-4">
                        <img
                            src="/image/home/get-your-qr.png"
                            alt="digital menu features"
                            class="col-12"
                        />
                    </div>
                    <!-- End col-md-6 Class -->
                </div>
                <!-- End Row Class -->
            </div>
            <!-- End the-benefits Class -->
        </div>
        <!-- End Container -->
        <div class="container mt-5 mb-5 the-benefits select-your-menu">
            <div class="heading">
                <h3 class="h4">{{ lang.Choose_your_design }}</h3>
                <h4 class="h4 center-top-border">{{ lang.free_design }}</h4>
            </div>
            <div class="content container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <img
                                src="/image/home/qr-menu.jpg"
                                alt="QR-menu"
                                class="col-12"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <img
                                src="/image/home/qr-menu2.jpg"
                                alt="QR-menu"
                                class="col-12"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <img
                                src="/image/home/qr-menu3.jpg"
                                alt="QR-menu"
                                class="col-12"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <img
                                src="/image/home/qr-menu4.png"
                                alt="QR-menu"
                                class="col-12"
                            />
                        </div>
                    </div>
                </div>
                <!-- End Row Class -->
            </div>
            <!-- End content Class -->
        </div>
        <!-- End select-your-menu Class -->

        <div class="container mt-5 mb-5 pt-5 the-benefits request_your_design">
            <div class="heading">
                <h3 class="h4">{{ lang.Request_your_design }}</h3>
                <h4 class="h4 center-top-border">{{ lang.within_24_hours }}</h4>
            </div>
            <div class="content container">
                <div class="col-md-12 row">
                    <div class="col-md-6 p-0 row">
                        <h5 class="h5 line-60">
                            {{ lang.Move_to_the_digital_menu_and_start }}
                        </h5>
                        <h5 class="h5 line-40">
                            {{ lang.You_must_create_your_store }}
                        </h5>
                        <a
                            :href="casher_program"
                            class="btn btn-warning bg-new-warning col-md-6 m-auto bold p-2 mt-2 mb-2"
                        >
                            {{ lang.learn_more }}
                        </a>
                        <div class="clear"></div>
                        <div class="m-auto col-md-4 dig-menu-btn-wa d-grid">
                            <link
                                rel="stylesheet"
                                href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"
                            />
                            <a
                                href="https://api.whatsapp.com/send?phone=+201061830653&text="
                                class="btn-style-wa"
                                target="_blank"
                            >
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img
                            src="/image/home/re-qr-des-im.gif"
                            alt="digital menu features"
                            class="col-12"
                        />
                    </div>
                </div>
            </div>
            <!-- End content Class -->
        </div>
        <!-- End request_your_design Class -->
    </div>
</template>

<style scoped>
ul {
    cursor: pointer;
}

.slide-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}

.slide-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}
.slide-enter-to,
.slide-leave {
    max-height: 100px;
    overflow: hidden;
}

.slide-enter,
.slide-leave-to {
    overflow: hidden;
    max-height: 0;
}
</style>

<script>
import slideDown from "./layouts/slideDown.vue";
export default {
    components: { slideDown },
    props: ["home", "casher_program"],
    name: "CasherProgram",
    data: function () {
        return {
            lang: this.getLang(),
            isShow: false,
            locale: this.getLocale(),
        };
    },
    methods: {},
};
</script>
