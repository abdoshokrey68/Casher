<template>
    <div class="col-md-12">
        <div id="root" @click="isShow = !isShow">
            <div style="background: #ebebeb">
                <i
                    id="icon-slide-up"
                    :style="'transform:rotate(' + turn + 'turn)'"
                    class="fas fa-chevron-down p-3 float-end"
                ></i>
                <h5 class="h5 text-center p-3 bold text-uppercase">
                    {{ heading }}
                </h5>
            </div>
            <transition name="slide">
                <div class="child bg-light" v-if="isShow">
                    <p class="lead text-initial text-uppercase p-2">
                        {{ msg }}
                    </p>
                </div>
            </transition>
        </div>
    </div>
</template>

<style scoped>
div {
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
.slide .child .text-justify {
    text-align: justify !important;
}
</style>
<script>
export default {
    name: "SlideDown",
    data: function () {
        return {
            isShow: false,
            turn: 1,
        };
    },
    watch: {
        isShow: function () {
            if (this.turn == 0.5) {
                this.turn = 1;
            } else {
                this.turn = 0.5;
            }
        },
    },
    methods: {
        getClass: function () {
            return "";
        },
    },
    props: ["heading", "msg"],
};
</script>
