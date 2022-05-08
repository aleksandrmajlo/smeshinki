<template>
    <div class=" mb-3 mt-5">
        <div v-for="(item, index) in items" :key="index" class="mb-5">
            <h5 class="text-center">{{ item.title }}</h5>
            <span v-html="item.text"></span>
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
            <span v-if="item.video">
                    <share :url="loadVideo(item.video)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
            </span>
            <span v-else>
                    <share :url="loadImg(item.photo)" :title="item.show_title?item.title:''" :description="item.show_title?item.description:''"/>
            </span>
        </div>
        <div class="text-center">
            <p v-show="items.length<1" class="text-info">Привітаннь немає</p>
            <a v-show="items&&items.length>0" class="btn btn-outline-info" :href="url">Переглянути всі привітання</a>
        </div>
    </div>
</template>

<script>
    import Share from "../Share.vue";
    export default {
        name: "Post",
        props: [
            'items'
            ,'url'
        ],
        components: {
            Share
        },
        methods: {
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
