<template>
    <div id="home-compo">
        <div class="home-header">
            <div class="header-text col-md-4">
                <h1 class="h2">{{ lang.why_out_software }}</h1>
                <a href="#" class="btn btn-warning col-md-12">
                    {{ lang.learn_more }}
                </a>
            </div>
        </div>
        <div id="key-features" class="bg-dark">
            <div class="container">
                <div class="row b-0">
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-clock fa-3x text-warning m-3"></i>
                        <h3 class="h3">24/7</h3>
                        <h3 class="h3">{{ lang.support }}</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-handshake fa-3x text-warning m-3"></i>
                        <h3 class="h3">96%</h3>
                        <h3 class="h3">{{ lang.customer_retention }}</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-star fa-3x text-warning m-3"></i>
                        <h3 class="h3">+10</h3>
                        <h3 class="h3">{{ lang.feature }}</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-shield fa-3x text-warning m-3"></i>
                        <h3 class="h3">100%</h3>
                        <h3 class="h3">{{ lang.security }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="our-programs container">
            <div class="heading">
                <h3 class="h3">{{ lang.our_programs }}</h3>
            </div>
            <div class="programs-info">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-6 col-xs-12 p-1 mt-2 mb-2">
                        <a :href="casher_route" class="link-unstyled">
                            <div class="prog-info">
                                <h1 class="h4 bold text-d-blue p-2">
                                    <i class="fas fa-utensils mr-2 ml-2"></i>
                                    <span> {{ lang.res_pro }} </span>
                                </h1>
                                <p>
                                    {{ lang.res_des }}
                                </p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="/image/home/materdine-teaser.jpg"
                                    alt="prog-image"
                                    class="col-md-12 image-res"
                                />
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 p-1 mt-2 mb-2">
                        <a :href="digital_menu" class="link-unstyled">
                            <div class="prog-info">
                                <h1 class="h4 bold text-d-blue p-2">
                                    <i class="fas fa-utensils mr-2 ml-2"></i>
                                    <span> {{ lang.dig_men }} </span>
                                </h1>
                                <p>
                                    {{ lang.dig_des }}
                                </p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="/image/home/qr-degital-menu.jpg"
                                    alt="prog-image"
                                    class="col-md-12 image-res"
                                />
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12 p-1 mt-2 mb-2">
                        <a href="#" class="link-unstyled">
                            <div class="prog-info">
                                <h1 class="h4 bold text-d-blue p-2">
                                    <i
                                        class="fas fa-face-surprise mr-2 ml-2"
                                    ></i>
                                    <span> {{ lang.soon }} </span>
                                </h1>
                                <p>{{ lang.new_program }}</p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="/image/home/soon.jpg"
                                    alt="prog-image"
                                    class="col-md-12 image-res"
                                />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="said-about-us mt-5 mb-5">
            <div class="bg-dark p-2 text-light row">
                <div class="col-md-10 mt-3 mb-3 row">
                    <div class="col-md-6">
                        <img
                            src="/image/home/why-choose-us.jpg"
                            class="col-md-12 borderd image-res"
                            alt="choose-us"
                        />
                    </div>
                    <div class="col-md-6 p-2">
                        <h2 class="h3 p-2">{{ lang.why_us }}</h2>
                        <p class="h4 line-60">
                            {{ lang.the_primary_purpose }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HomeCompoentn",
    props: ["casher_route", "locale", "digital_menu"],
    data: function () {
        return {
            lang: this.getLang(),
        };
    },
    mounted() {
        // console.log();
    },
};
</script>
