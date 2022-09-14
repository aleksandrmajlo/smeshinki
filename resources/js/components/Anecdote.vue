<template>
    <div class="card position-relative oneAnectod mb-5" v-cloak>
        <button
            :disabled="disabled"
            class="link_button leftMy buttonNot"
            @click.prevent="top()" >
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
        <button
            :disabled="disabled"
            class="link_button rightMy buttonNot"
            @click.prevent="down()" >
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </button>
        <div class="card-body">
            <h5 class="card-title text-center">{{ title }}</h5>
            <div class="card-text text-left mb-2">
                <span v-html="description"></span>
            </div>
            <div class=" mb-2  ">
                <rating-like post_type="anecdote"
                             :likes="likes"
                             :total_votes="total_votes"
                             :post_id="id"></rating-like>
            </div>
            <div class="text-center mb-2">
                <a href="/anecdotes" class="btn btn-outline-primary">До анекдотів</a>
            </div>

            <!-- <div class="text-center mb-2"> -->
                 <!-- <a v-if="auth==1"  href="/login" class="btn btn-outline-primary">Підписатися на розсилання</a> -->
                 <!-- <a v-if="auth==1" href="#" data-fancybox="dialog" data-src="#form_subscription" class="btn btn-outline-primary">Підписатися на розсилання</a> -->
                 <!-- <a v-else
                 href="#" data-fancybox="dialog" data-src="#form_subscription" class="btn btn-outline-primary">Підписатися на розсилання</a> -->
            <!-- </div> -->
        </div>
    </div>
</template>

<script>
    import {eventBus} from "../app";
    export default {
        name: "Anecdote",
        data() {
            return {
                ids: [],// ид показанных анектодов
                id: '',
                title: "",
                description: "",
                total_votes: '',//
                likes: {},
                disabled:false
            };
        },
        props:['auth'],
        created() {
            this.getAnectod();
            eventBus.$on("anecdoteChange", () => {
                this.getAnectod();
            });
        },
        methods: {
            getAnectod() {
                axios
                    .post("/getAnecdote", {
                        ids: this.ids,
                    })
                    .then((res) => {
                        this.title = res.data.anecdote.title;
                        this.description = res.data.anecdote.description;
                        this.id = res.data.anecdote.id;
                        this.total_votes = res.data.anecdote.total_votes;
                        this.likes = res.data.anecdote.likes;
                        if (res.data.new_arr) {
                            this.ids = [];
                            this.ids.push(res.data.anecdote.id);
                        } else {
                            this.ids.push(res.data.anecdote.id);
                        }
                        eventBus.$emit('changeDataRating',{});
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(() => {
                        this.disabled=false;
                    });
            },
            top(){
               this.disabled=true;
               this.getAnectod();
            },
            down(){
                this.disabled=true;
                this.getAnectod();
            }
        },
    };
</script>

