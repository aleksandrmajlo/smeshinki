<template>
    <div v-cloak>
        <button :disabled="disabled" class="buttonNot"
              @click.prevent="likeBlog">
            <i :style="{ color: color}" class="fa fa-thumbs-up" aria-hidden="true"></i>
        </button>
        <span>Подобається {{ alllikes }}</span>
        <!--    <span class="">-->
        <!--      {{alllikes}}-->
        <!--    </span>-->
        <!--    <a href="#" @click.prevent="dislikeBlog">-->
        <!--        <i class="fa fa-thumbs-down" aria-hidden="true"></i>-->
        <!--        ({{ allDislike }})-->
        <!--    </a>-->
    </div>
</template>
<script>
    export default {
        name: "LikeComponent",
        data() {
            return {
                alllikes: '',
                allDislike: '',
                disabled: false,
                text: 'Вам та ще '
            };
        },
        props: [
            'post_type', 'post_id','color'
        ],
        mounted() {
            axios.post('/getLike', {
                post_type: this.post_type,
                post_id: this.post_id,
            })
                .then(res => {
                    this.alllikes = res.data.alllikes
                })
                .catch(err => {
                    console.error(err);
                })
        },
        methods: {
            likeBlog() {
                this.disabled = true;
                axios.post('/addLike', {
                    post_type: this.post_type,
                    post_id: this.post_id,
                })
                    .then(res => {
                        this.alllikes = res.data.alllikes
                    })
                    .catch(err => {
                        console.error(err);
                    })

            },
            dislikeBlog() {

            }
        }
    }
</script>


