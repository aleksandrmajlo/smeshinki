<template>
    <div class="WrapContent">
        <loading :active.sync="isLoading" :is-full-page="fullPage"/>
        <div class="card" v-cloak>
            <div  class="WrapLeftRight d-flex justify-content-between mb-3 ">
                <button
                    class="link_button_lr leftMy"
                    :disabled="disabledTop"
                    @click.prevent="top()"
                >
                    <img src="/img/left-arrow.png"/>
                </button>
                <button
                    class="link_button_lr rightMy"
                    :disabled="disabledDown"
                    @click.prevent="down()"
                >
                    <img src="/img/right-arrow.png"/>
                </button>
            </div>
            <div class="PaginationMy text-center mb-3">Показано {{items.length}} публікацій з {{total}}</div>
            <div class="WrapItems mb-5" v-for="item in items" :key="item.id">
                <div
                    v-show="item.photo"
                    class="bg-image hover-overlay ripple"
                    data-mdb-ripple-color="light">
                    <img :src="loadImg(item.photo)" class="img-fluid" rel="preload"/>
                    <a data-fancybox :href="loadImg(item.photo)">
                        <div
                            class="mask"
                            style="background-color: rgba(251, 251, 251, 0.15)"
                        ></div>
                    </a>
                </div>
                <div class="player-container" v-if="item.video">
                    <vue-core-video-player
                        :autoplay="false"
                        :src="loadVideo(item.video)"
                    ></vue-core-video-player>
                </div>
                <div class="card-body mb-2" v-show="item.show_title">
                    <h5 v-show="item.title.search('Telegram')==-1" class="card-title">{{ item.title }}</h5>
                    <span v-html="item.description"></span>
                </div>
                <span v-if="item.video">
                    <share :url="loadVideo(item.video)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
                </span >
                <span v-else>
                    <share :url="loadImg(item.photo)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
                </span>
            </div>
            <!-- left right -->
            <div class="PaginationMy text-center mb-3">Показано {{items.length}} публікацій з {{total}}</div>
            <div id="WrapLeftRight" class="WrapLeftRight d-flex justify-content-center mb-3 ">
                <button :disabled="disabledTen" class="btn btn-primary"
                   @click.prevent="showTen"
                   href="#">Показати ще 10</button>
                <!--
                <button
                    class="link_button_lr leftMy"
                    :disabled="disabledTop"
                    @click.prevent="top()"
                >
                    <img src="/img/left-arrow.png"/>
                </button>
                <button
                    class="link_button_lr rightMy"
                    :disabled="disabledDown"
                    @click.prevent="down()"
                >
                    <img src="/img/right-arrow.png"/>
                </button>
                -->
            </div>
<!--            <button-->
<!--                class="link_button topMy"-->
<!--                :disabled="disabledTop"-->
<!--                @click.prevent="top()"-->
<!--            >-->
<!--                <img src="/img/top.png"/>-->
<!--            </button>-->
        </div>
    </div>
</template>
<script>
    import axios from "axios";
    import Share from "./Share.vue";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";
    import {eventBus} from "../app";
    export default {
        name: "Word",
        data() {
            return {
                disabledTop: true,
                disabledDown: true,
                disabledTen: true,// показать еще 10

                firstId:null,
                lastId:null,
                firstIdCol:null,// первое ид в кол все
                lastIdCol:null,// первое ид в кол все
                // page:1,// страница
                total:0,// кол-во страниц
                to:'',   // сколько показум
                show_title: false,
                items: {},

                isLoading: true,
                fullPage: false,

            };
        },
        components: {
            Loading,
            Share
        },
        created() {
            this.getWord();
        },
        mounted() {
        },
        computed: {},
        methods: {
            // получить
            getWord(type) {
                this.isLoading = true;
                axios
                    .get("/getWord", {
                        params:{
                            firstId: this.firstId,
                            lastId: this.lastId,
                            type:type,
                        }
                        // type: type,
                    })
                    .then((res) => {
                        //  if(res.data.words){
                             this.items=res.data.words;
                             this.firstId=res.data.firstId;
                             this.lastId=res.data.lastId;
                             this.firstIdCol=res.data.firstIdCol;
                             this.lastIdCol=res.data.lastIdCol;
                        this.total=res.data.count

                         this.setDisabled();
                        /*
                        const data=res.data;
                        this.total=data.last_page;
                        this.items=data.data;
                        this.to=data.to;

                        if(this.page==1){
                            this.disabledTop = true;
                        }else{
                            this.disabledTop = false;
                        }
                        if(this.page==data.last_page){
                            this.disabledDown = true;
                        }else{
                            this.disabledDown = false;
                        }
                        */
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(() => {
                        this.isLoading = false;
                    });
            },
            // вверх
            top(anecdot = false) {
                this.getWord('top');
                if (!anecdot) {
                    eventBus.$emit("anecdoteChange");
                }

            },
            // вниз
            down(anecdot = false) {
                this.getWord('down');
                if (!anecdot) {
                    eventBus.$emit("anecdoteChange");
                }
            },
            // установить кнопки
            setDisabled(){

                if(this.firstId==this.firstIdCol){
                    this.disabledTop=true;
                }else{
                    this.disabledTop=false;
                }

                if(this.lastId==this.lastIdCol){
                    this.disabledDown=true;
                    this.disabledTen=true;
                }else{
                    this.disabledDown=false;
                    this.disabledTen=false;
                }

            },
            // показать еще 10
            showTen(){
                this.getWord('ten');
            },
            loadImg(src){
                let url=process.env.MIX_API_URL+'/'+src;
                const image = new Image();
                image.onload = () => {
                    this.src = url;
                };
                image.src = url;
                return url;
            },
            loadVideo(src){
                return process.env.MIX_API_URL+'/'+src;
            }
        },
    };
</script>


