<template>
    <a @click="scrollTop" v-show="visible" class="bottom-right">
        <i class="fa fa-arrow-up" ></i>
    </a>
</template>

<script>
    export default {
        name: "ScrollTop",
        data () {
            return {
                visible: false
            }
        },
        methods: {
            scrollTop: function () {
                $("html, body").animate({ scrollTop: "0" }, 500);
            },
            scrollListener: function (e) {
                this.visible = window.scrollY > 150
            }
        },
        mounted: function () {
            window.addEventListener('scroll', this.scrollListener)
        },
        beforeDestroy: function () {
            window.removeEventListener('scroll', this.scrollListener)
        }
    }
</script>

<style scoped>
    .bottom-right {
        font-size: 24px;
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;
    }
</style>
