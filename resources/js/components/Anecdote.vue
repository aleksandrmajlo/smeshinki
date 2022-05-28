<template>
    <div class="card position-relative" v-cloak>
        <loading :active.sync="isLoading" :is-full-page="fullPage"/>
        <div class="card-body">
            <h5 class="card-title text-center">{{ title }}</h5>
            <div class="card-text text-left">
                <span v-html="description"></span>
            </div>
        </div>
    </div>
</template>

<script>
    import {eventBus} from "../app";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";

    export default {
        name: "Anecdote",
        data() {
            return {
                title: "",
                description: "",
                ids: [],
                isLoading: true,
                fullPage: false,
            };
        },
        components: {
            Loading,
        },
        created() {
            this.getAnectod();
            eventBus.$on("anecdoteChange", () => {
                console.clear()
                console.log('anecdoteChange')
                this.getAnectod();
            });
        },
        methods: {

            getAnectod() {
                this.isLoading = true;
                axios
                    .post("/getAnecdote", {
                        ids: this.ids,
                    })
                    .then((res) => {
                        this.title = res.data.anecdote.title;
                        this.description = res.data.anecdote.description;
                        if (res.data.new_arr) {
                            this.ids = [];
                            this.ids.push(res.data.anecdote.id);
                        } else {
                            this.ids.push(res.data.anecdote.id);
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                    })
                    .then(() => {
                        this.isLoading = false;
                    });
            },
        },
    };
</script>

