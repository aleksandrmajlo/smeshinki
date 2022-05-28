<template>
    <div class=" mb-3 mt-3">
        <div v-for="(item, index) in items" :key="item.id" class="mb-2 text-center">
            <a :href="url+'#id'+item.id" class="text-center">{{ item.title }}</a>
        </div>
        <div class="text-center">
            <p v-show="items.length<1" class="text-danger">Привітання немає</p>
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
