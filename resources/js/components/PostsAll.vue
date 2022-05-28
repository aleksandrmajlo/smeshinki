<template>
    <div class="WrapContent">
        <loading :active.sync="isLoading" :is-full-page="fullPage"/>
        <div class="card" v-cloak>
            <button
                class="link_button 6666 downMy"
                :disabled="disabledDown"
                @click.prevent="down()">
                <img src="/img/down.png"/>
            </button>
            <div class="PaginationMy text-center mb-3">Сторінка {{page}} з {{total}} (показано {{items.length}} публікацій)</div>
            <div class="WrapLeftRight d-flex justify-content-between mb-3 ">
                <button
                    class="link_button_lr 555 leftMy"
                    :disabled="disabledTop"
                    @click.prevent="top(1)"
                >
                    <img src="/img/left-arrow.png"/>
                </button>
                <button
                    class="link_button_lr 444 rightMy"
                    :disabled="disabledDown"
                    @click.prevent="down(1)"
                >
                    <img src="/img/right-arrow.png"/>
                </button>
            </div>

            <div v-for="(item, index) in items" :key="item.id" class="mb-2 ">
                <h3  class="text-center card-title">{{ item.title }}</h3>
                <p class="card-text mb-3">
                    <span v-html="item.text"></span>
                </p>
                <div
                    v-show="item.photo"
                    class="bg-image hover-overlay ripple mb-3"
                    data-mdb-ripple-color="light">
                    <img :src="loadImg(item.photo)" class="img-fluid" rel="preload"/>
                    <a data-fancybox :href="loadImg(item.photo)">
                        <div
                            class="mask"
                            style="background-color: rgba(251, 251, 251, 0.15)"
                        ></div>
                    </a>
                </div>
                <div class="player-container mb-3" v-if="item.video">
                    <vue-core-video-player
                        :autoplay="false"
                        :src="loadVideo(item.video)"
                    ></vue-core-video-player>
                </div>

                <template v-if="user_id">
                    <my-favorites :user_id="user_id"
                                  :post_id="item.id"
                                  :fav="inFav(item.id)"></my-favorites>
                </template>
                <template v-else>
                    <my-favorites :user_id="user_id" :post_id="item.id"></my-favorites>
                </template>

                <rating :rating_avg="item.rating_avg"
                        :post_id="item.id"
                        :total_votes="item.total_votes"
                ></rating>

                <span v-if="item.video">
                     <share :url="loadVideo(item.video)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
                </span>
                <span v-else>
                     <share :url="loadImg(item.photo)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
                </span>
                <div class="mt-3 w-100" v-if="calendars.length>0">
                    <a :href="calendar_url(item.calendar_id)" class="btn  btn-outline-primary w-100">Перейти до дати {{calendar_date(item.calendar_id)}}</a>
                </div>
                <hr class="myHr" />
            </div>
            <!-- left right -->
            <button
                class="link_button 3333 topMy"
                :disabled="disabledTop"
                @click.prevent="top()"
            >
                <img src="/img/top.png"/>
            </button>
            <!-- left right -->
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
        name: "PostsAll",
        data() {
            return {
                disabledTop: true,
                disabledDown: false,

                page: 1,// страница
                total: '',// кол-во страниц
                to: '',   // сколько показум
                show_title: false,
                items: {},

                isLoading: true,
                fullPage: false,

                user_id:false,
                isFav:[],// массив фаворитов

                calendars:[],// календарь

            };
        },
        components: {
            Loading,
            Share
        },
        created() {
            this.getPost();
        },
        mounted(){
            this.getUser();
        },
        methods: {
            // получаем записи
            getPost() {
                this.isLoading = true;
                axios
                    .get("/getPosts", {
                        params: {
                            page: this.page,
                        }
                    })
                    .then((res) => {
                        const data = res.data;
                        this.total = data.last_page;
                        this.items = data.data;
                        this.to = data.to;

                        if (this.page == 1) {
                            this.disabledTop = true;
                        } else {
                            this.disabledTop = false;
                        }
                        if (this.page == data.last_page) {
                            this.disabledDown = true;
                        } else {
                            this.disabledDown = false;
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(() => {
                        this.isLoading = false;
                    });

            },
            // получить пользователя
            getUser(){
               axios.get('/getUser')
               .then(res => {
                   this.user_id=res.data.user_id;
                   this.isFav=res.data.isFav;
                   this.calendars=res.data.calendars;
               })
               .catch(err => {
                   console.error(err);
               })
            },
            // проверить или в фаворитах
            inFav(post_id){
               return this.isFav.includes(post_id)
            },
            // установить урл каталога
            calendar_url(calendar_id){
                console.log()
                const calendar = this.calendars.find((obj) => {
                    return obj.id === calendar_id;
                });
                return calendar.url;
            },
            // установить урл каталога
            calendar_date(calendar_id){
                console.log()
                const calendar = this.calendars.find((obj) => {
                    return obj.id === calendar_id;
                });
                return calendar.date_write;
            },
            // вверх
            top(anecdot = false) {
                this.page = this.page - 1;
                this.getPost();
                if (!anecdot) {
                    eventBus.$emit("anecdoteChange");
                }
            },
            // вниз
            down(anecdot = false) {
                this.page = this.page + 1;
                this.getPost();
                if (!anecdot) {
                    eventBus.$emit("anecdoteChange");
                }
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

        }
    }
</script>
