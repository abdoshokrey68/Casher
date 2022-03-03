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
        <div class="the-benefits">
            <div class="heading">
                <h3 class="h3">
                    {{ lang.dig_men }}
                </h3>
                <h6 class="col-5 m-auto h5 line-40">
                    {{ lang.Give_your_customers_a_safe }}
                </h6>
            </div>

            <div id="the-benefits-content" class="row mt-5">
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

        <div class="the-benefits">
            <div class="heading">
                <h3 class="h4">{{ lang.Features_Available_In_The_App }}</h3>
                <h4 class="h4 center-top-border">{{ lang.current_version }}</h4>
            </div>
            <div class="content container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.The_black_box"
                                :msg="lang.We_understand_the_importance"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.multilanguage"
                                :msg="lang.It_is_a_multi_language_program"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.synchronous_asynchronous"
                                :msg="lang.The_restaurant_management_system"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.give_roles"
                                :msg="lang.The_store_manager_can_grant"
                            >
                            </slide-down>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="
                                    lang.Possibility_to_review_all_previous_checks
                                "
                                :msg="lang.Through_the_open_button"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Store_employees"
                                :msg="lang.Through_the_Users_and_Permissions"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Possibility_to_delete"
                                :msg="lang.Items_can_be_deleted"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Possibility_to_delete_the_entire"
                                :msg="lang.The_user_can_also_delete"
                            >
                            </slide-down>
                        </div>
                    </div>
                </div>
                <!-- End Row Class -->
            </div>
            <!-- End container Class -->
        </div>
        <!-- End the-benefits Class -->
        <div class="clear"></div>
        <div class="the-benefits mt-5">
            <div class="heading">
                <h3 class="h3">{{ lang.Features_coming_soon }}</h3>
                <h4 class="h4 center-top-border">
                    {{ lang.Upcoming_releases }}
                </h4>
            </div>
            <div class="content container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Complaint_Management"
                                :msg="lang.Are_you_having_trouble"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Monitoring_the_working_hours"
                                :msg="lang.Managing_employee_time_and"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.daily_plate"
                                :msg="lang.One_of_the_most_difficult"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Order_Tracking"
                                :msg="lang.Allow_your_customers_to_track"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Increase_sales_automatically"
                                :msg="lang.This_smart_feature_is_a_source"
                            >
                            </slide-down>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Customer_preferences"
                                :msg="lang.The_program_determines"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="
                                    lang.monitoring_of_stock_and_prescription
                                "
                                :msg="lang.What_is_the_benefit_of"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Customers_can_reserve_tables"
                                :msg="lang.It_is_possible_to_reserve"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Possibility_to_issue_an_invoice"
                                :msg="lang.The_restaurant_and_cafe_management"
                            >
                            </slide-down>
                        </div>
                        <div class="col-md-12 p-0">
                            <slide-down
                                :heading="lang.Possibility_to_pay_with_a_visa"
                                :msg="lang.The_advantage_of_paying_in_cash"
                            >
                            </slide-down>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    props: ["home"],
    name: "CasherProgram",
    data: function () {
        return {
            lang: this.getLang(),
            isShow: false,
        };
    },
};
</script>
