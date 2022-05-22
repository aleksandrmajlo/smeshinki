<template>
    <div class="mb-3 position-relative">
          <loading :active.sync="isLoading" :is-full-page="fullPage"  loader="dots" />
        <h5>Рейтинг:</h5>
        <div class="wrapRating" v-if="isShow">
            <star-rating
                @rating-selected="setRating"
                :star-size="16"
                active-color="#1266f1"
                v-model="rating"></star-rating>
        </div>
        <div>
            Середня оцінка <span class="fw-bold">{{rating_avg_}}</span  > з <span class="fw-bold">{{total_votes_}}</span> відгуків
        </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating'
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";
    export default {
        name: "Rating",
        data() {
            return {
                rating: 0,
                rating_avg_:this.rating_avg,
                total_votes_:this.total_votes,
                isShow:1,
                isLoading: false,
                fullPage: false,
            }
        },
        props: ['rating_avg', 'total_votes','post_id'],
        components: {
            Loading,
            StarRating
        },
        methods: {
            setRating: function (rating) {
                this.isLoading=true;
                axios.post('/addRating', {
                    rating: rating,
                    post_id: this.post_id
                })
                    .then(res => {
                        this.isShow = false;
                        this.rating_avg_=res.data.rating_avg;
                        this.total_votes_=res.data.total_votes;
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

