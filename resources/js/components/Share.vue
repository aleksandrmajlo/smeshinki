<template>
    <div>

        <h5>Поділиться:</h5>
        <div class="ShareWrap d-flex flex-wrap  justify-content-between">
            <ShareNetwork
                network="facebook"
                :url="url"
                :title="title"
                :description="description"
            >
                <i   class="fab fa-facebook-f"></i>
            </ShareNetwork>
            <ShareNetwork
                network="WhatsApp"
                :url="url"
                :title="title"
                :description="description"
            >
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
            </ShareNetwork>
            <ShareNetwork
                network="Telegram"
                :url="url"
                :title="title"
                :description="description"
            >
                <i class="fab fa-telegram" aria-hidden="true"></i>
            </ShareNetwork>
            <ShareNetwork
                network="Viber"
                :url="url"
                :title="title"
                :description="description"
            >
                Viber
            </ShareNetwork>

            <ShareNetwork
                network="Twitter"
                :url="url"
                :title="title"
                :description="description"
            >
                <i class="fab fa-twitter"></i>
            </ShareNetwork>
            <ShareNetwork
                network="SMS"
                :url="url"
                :title="title"
                :description="description"
            >
            SMS
            </ShareNetwork>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Share",

        props:[
           'url','title','description','post_id'
        ],

    }
</script>
