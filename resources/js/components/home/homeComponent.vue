<template>
    <div id="home-compo">
        <div class="home-header">
            <div class="header-text col-md-4">
                <h1 class="h2">Why you should use our software</h1>
                <a href="#" class="btn btn-warning col-md-12"> Learn more </a>
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
                        <h3 class="h3">Support</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-handshake fa-3x text-warning m-3"></i>
                        <h3 class="h3">96%</h3>
                        <h3 class="h3">Customer Retention</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-star fa-3x text-warning m-3"></i>
                        <h3 class="h3">+10</h3>
                        <h3 class="h3">Feature</h3>
                    </div>
                    <div
                        class="col-md-3 mt-2 mb-2 p-3 text-center text-light bold"
                    >
                        <i class="fas fa-shield fa-3x text-warning m-3"></i>
                        <h3 class="h3">100%</h3>
                        <h3 class="h3">Security</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="our-programs container">
            <div class="heading">
                <h3 class="h3">Our Programs</h3>
            </div>
            <div class="programs-info">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-6 col-xs-12 p-1 mt-2 mb-2">
                        <a :href="casher_route" class="link-unstyled">
                            <div class="prog-info">
                                <h1 class="h4 bold text-d-blue p-2">
                                    <i class="fas fa-utensils mr-2 ml-2"></i>
                                    <span> Restaurants Program </span>
                                </h1>
                                <p>
                                    The program works on managing restaurants
                                    and cafes
                                </p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="image/home/materdine-teaser.jpg"
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
                                    <i class="fas fa-utensils mr-2 ml-2"></i>
                                    <span> Digital Menu </span>
                                </h1>
                                <p>
                                    Easy-to-scan restaurant menu for customers
                                </p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="image/home/qr-degital-menu.jpg"
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
                                    <span> Soon </span>
                                </h1>
                                <p>New Program</p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="image/home/soon.jpg"
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
                                    <span> Soon </span>
                                </h1>
                                <p>New Program</p>
                            </div>
                            <div class="prog-img">
                                <img
                                    src="image/home/soon.jpg"
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
                        <h2 class="h3 p-2">Why Choose Us ?</h2>
                        <p class="h4 line-60">
                            The primary purpose and objective of our programs is
                            to revolutionize how businesses are run easily and
                            perfectly.
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
    props: ["casher_route"],
};
</script>
