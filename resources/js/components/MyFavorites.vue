<template>
    <div class="mb-3 position-relative">
        <loading :active.sync="isLoading" :is-full-page="fullPage"  loader="dots" />
        <div v-if="! user_id">
            <h5>Додати в вибране</h5>
            <p class="text-info">
                Необхідно <a href="/register">зареєструватись</a> або <a href="/login">залогінитись</a>
            </p>
        </div>
        <div v-else>
            <h5>Вибране</h5>
            <a href="#" v-if="!isFavor" @click.prevent="add" title="Додати"><span>Додати</span> <i class="fa fa-bookmark" aria-hidden="true"></i></a>
            <a href="#" v-else @click.prevent="del" title="Видалити"><span>Видалити</span> <i class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
    </div>
</template>

<script>
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";

    export default {
        name: "MyFavorites",
        data() {
            return {
                isFavor: this.fav,
                isLoading: false,
                fullPage: false,
            }
        },
        components: {
            Loading,
        },
        props: ['user_id', 'post_id','fav'],
        methods: {

            add() {
                this.isLoading=true;
                axios.post('/addFav', {
                    user_id: this.user_id,
                    post_id: this.post_id
                })
                    .then(res => {
                        this.isFavor = true;
                    })
                    .catch(err => {
                        console.error(err);
                    }).then(()=>{
                        this.isLoading=false;
                    })
            } ,
            del() {
                this.isLoading=true;
                axios.post('/delFav', {
                    user_id: this.user_id,
                    post_id: this.post_id
                })
                    .then(res => {
                        this.isFavor = false;
                    })
                    .catch(err => {
                        console.error(err);
                    }).then(()=>{
                        this.isLoading=false;
                    })
            }

        }
    }
</script>

