<template>
    <div class="WrapContent">
<!--        <loading :active.sync="isLoading" :is-full-page="fullPage"/>-->
        <div class="card" v-cloak>
            <div class="PaginationMy text-center mb-3">Показано {{ items.length }} публікацій з {{ total }}</div>
            <div class="WrapItems mb-5 " v-for="item, ind in items" :key="item.id">
                <!--
                <template v-if="ind==0">
                    <button
                         class="link_button_lr leftMy"
                          :disabled="disabledTop"
                          @click.prevent="top()"
                       >
                       <i class="fa fa-arrow-left" aria-hidden="true"></i>
                   </button>
                   <button
                         class="link_button_lr rightMy"
                        :disabled="disabledDown"
                         @click.prevent="down()"
                     >
                     <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </template>
                -->
                <div v-show="item.photo" class="bg-image hover-overlay ripple text-center"
                     data-mdb-ripple-color="light">
                    <img :src="loadImg(item.photo)" class="img-fluid" rel="preload"/>
                    <a data-fancybox :href="loadImg(item.photo)">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                    </a>
                </div>
                <div class="player-container" v-if="item.video">
                    <vue-core-video-player :autoplay="false" :src="loadVideo(item.video)"></vue-core-video-player>
                </div>
                <div class="card-body mb-2" v-show="item.show_title">
                    <h5 v-show="item.title.search('Telegram') == -1" class="card-title">{{ item.title }}</h5>
                    <span v-html="item.description"></span>
                </div>
                <div class="col-lg-8 mb-2 mt-2 mx-auto text-center">
                    <template v-if="item.video">
                        <share :url="loadVideo(item.video)" :title="item.show_title ? item.title : ''"
                               :description="item.show_title ? item.description : ''"/>
                    </template>
                    <template v-else>
                        <share :url="loadImg(item.photo)" :title="item.show_title ? item.title : ''"
                               :description="item.show_title ? item.description : ''"/>
                    </template>
                </div>
                <div class="col-lg-8 mb-2 mx-auto ">
                    <rating-like post_type="word" :likes="item.likes" :total_votes="item.total_votes"
                                 :post_id="item.id"></rating-like>
                </div>
            </div>
            <!-- left right -->
            <div id="bottomblock" class="PaginationMy text-center mb-3">Показано {{ items.length }} публікацій з {{ total }}</div>
           <div style="position:relative;width: 100%;height: 60px;">
               <loading :active.sync="isLoading" :is-full-page="false"   loader="dots"  />
           </div>

            <!--
            <div id="WrapLeftRight" class="WrapLeftRight d-flex justify-content-center mb-3 ">
                <button :disabled="disabledTen" class="btn btn-primary"
                        @click.prevent="showTen"
                        href="#">Показати ще 10
                </button>
            </div>
            -->
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

                firstId: null,
                lastId: null,
                firstIdCol: null,// первое ид в кол все
                lastIdCol: null,// первое ид в кол все
                // page:1,// страница
                total: 0,// кол-во страниц
                to: '',   // сколько показум
                show_title: false,
                items: {},

                isLoading: true,
                fullPage: false,
                block_get_word: false

            };
        },
        components: {
            Loading,
            Share,
        },
        created() {
            this.getWord();
        },
        mounted() {
            let self = this;
            setTimeout(() => {
                var observer = new IntersectionObserver(function (entries) {
                    if (entries[0]['isIntersecting'] === true) {
                        if (entries[0]['intersectionRatio'] === 1) {
                            setTimeout(()=>{
                                self.getWord('ten');
                                self.block_get_word=true;
                                console.log('Target is fully visible in screen');
                            },500)
                        }
                    } else {
                        console.log('Target is not visible in screen');
                    }
                }, {threshold: [0, 0.5, 1]});

                observer.observe(document.querySelector("#bottomblock"));
            }, 2000)
        },
        computed: {},
        methods: {
            // получить
            getWord(type) {
                if(this.block_get_word){
                    return 1;
                }
                this.isLoading = true;
                axios
                    .get("/words", {
                        params: {
                            firstId: this.firstId,
                            lastId: this.lastId,
                            type: type,
                        }
                    })
                    .then((res) => {
                        this.items = res.data.words;
                        this.firstId = res.data.firstId;
                        this.lastId = res.data.lastId;
                        this.firstIdCol = res.data.firstIdCol;
                        this.lastIdCol = res.data.lastIdCol;
                        this.total = res.data.count
                        this.setDisabled();
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(() => {
                        this.isLoading = false;
                        setTimeout(()=>{
                            this.block_get_word=false;
                        },500)
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
            setDisabled() {
                if (this.firstId == this.firstIdCol) {
                    this.disabledTop = true;
                } else {
                    this.disabledTop = false;
                }

                if (this.lastId == this.lastIdCol) {
                    this.disabledDown = true;
                    this.disabledTen = true;
                } else {
                    this.disabledDown = false;
                    this.disabledTen = false;
                }
            },
            // показать еще 10
            showTen() {
                this.getWord('ten');
            },
            loadImg(src) {
                let url = process.env.MIX_API_URL + '/' + src;
                const image = new Image();
                image.onload = () => {
                    this.src = url;
                };
                image.src = url;
                return url;
            },
            loadVideo(src) {
                return process.env.MIX_API_URL + '/' + src;
            }
        },
    };
</script>


