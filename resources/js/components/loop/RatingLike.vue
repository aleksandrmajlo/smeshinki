<template>
    <div class="RatingLikeWrap">
        <VMenu popperClass="RatingLikePopper" placement="top">
            <template
                placement="top"
                #popper>
                <!--
                 :popperHideTriggers="triggers => ['mu']"
                 :hideTriggers="triggers => ['mu']"
                 -->
                <!--
                  <a v-close-popper>Close</a>
                -->
                <div class="tooltipMyWrap">
                    <a href="#" @click.prevent="setRating(6)" v-tooltip="{ content: '<span >Подобається</span>', html: true }">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        <span class="d-block d-md-none ">Подобається</span>
                    </a>
                    <a href="#" style="color: #ff0a78;" @click.prevent="setRating(7)" v-tooltip="{ content: '<span >Супер</span>', html: true }">
                        <i class="fa fa-heart"></i>
                        <span class="d-block d-md-none ">Супер</span>
                    </a>
                    <a href="#" @click.prevent="setRating(5)" v-tooltip="{ content: '<span >Ми разом</span>', html: true }">
                        <i class="fa fa-grin-stars"></i>
                        <span class="d-block d-md-none ">Ми разом</span>
                    </a>
                    <a href="#" style="color:#ffea08" @click.prevent="setRating(4)" v-tooltip="{ content: '<span >Ха-ха</span>', html: true }">
                        <i class="fa fa-smile-beam"></i>
                        <span class="d-block d-md-none ">Ха-ха</span>
                    </a>
                    <a href="#" style="color:#ffea08" @click.prevent="setRating(3)" v-tooltip="{ content: '<span >Ого</span>', html: true }">
                        <i class="fa fa-surprise"></i>
                        <span class="d-block d-md-none ">Ого</span>
                    </a>
                    <a href="#" style="color:#ffea08" @click.prevent="setRating(2)"
                        v-tooltip="{ content: '<span >Співчуваю</span>', html: true }">
                        <i class="fa fa-sad-cry"></i>
                        <span class="d-block d-md-none ">Співчуваю</span>
                    </a>
                    <a href="#" style="color: #c2b30b;"
                       @click.prevent="setRating(1)" v-tooltip="{ content: '<span >Обурливо</span>', html: true }">
                        <i class="fa fa-tired"></i>
                        <span class="d-block d-md-none ">Обурливо</span>
                    </a>
                </div>
            </template>
            <div class="likesWrap">

                <template v-if="Object.keys(likes_).length">
                    <div class="title">
                        Подобається
                        <span v-show="countall>0" class="countall">
                           {{countall}}
                       </span>:
                    </div>
                    <template  v-for="rating,key in ratings" v-if="typeof likes_[key]!='undefined'">
                        <a href="#" :style="{ color: rating.color}" >
                            <i class="fa " :class="rating.icon"></i>
                            <span>{{likes_[key]}}</span>
                            <span v-if="isRating==key">{{textMy}}</span>
                        </a>
                    </template>
                </template>
                <template v-else>
                    <a href="#" onclick="return false;" class="buttonNot mr-2">
                        <i :style="{ color: color}" class="fa fa-thumbs-up" aria-hidden="true"></i>
                    </a>
                    <span>Подобається </span>
                </template>
                <!-- <pre> -->
                    <!-- {{typeof likes}} -->
                    <!-- {{likes}} -->
                <!-- </pre> -->
            </div>
        </VMenu>
    </div>
</template>
<script>
    import {eventBus} from "../../app";
    export default {
        name: "RatingLike",
        data() {
            return {
                countall: 0,// количество оценок
                textMy: 'з Вашим',
                isRating: false,// или ставилась оценка
                likes_:this.likes,
                ratings: {
                    '6_n': {
                        'icon': 'fa-thumbs-up',
                        'tooltip': 'Подобається',
                        'color': '#1266f1'
                    },
                    '7_n': {
                        'icon': 'fa-heart',
                        'tooltip': 'Супер',
                        'color': '#ff0a78'
                    },
                    '5_n': {
                        'icon': 'fa-grin-stars',
                        'tooltip': 'Ми разом',
                        'color': '#1266f1'
                    },
                    '4_n': {
                        'icon': 'fa-smile-beam',
                        'tooltip': 'Ха-ха',
                        'color': '#ffea08'
                    },
                    '3_n': {
                        'icon': 'fa-surprise',
                        'tooltip': 'Ого',
                        'color': '#ffea08'
                    },
                    '2_n': {
                        'icon': 'fa-sad-cry',
                        'tooltip': 'Співчуваю',
                        'color': '#ffea08'
                    },
                    '1_n': {
                        'icon': 'fa-tired',
                        'tooltip': 'Обурливо',
                        'color': '#c2b30b'
                    },
                }
            };
        },
        props: [
            'rating_avg',
            'total_votes',
            'post_id',
            'post_type',
            'color',
            'likes'
        ],
        created() {
            this.countall = this.total_votes;
            eventBus.$on('changeDataRating', data => {
                this.isRating=false;;
                this.likes_=this.likes;
            })
        },
        methods: {
            // добавить рейтинг
            setRating: function (rating) {
                if (!this.isRating) {
                    // this.isLoading = true;
                    axios.post('/addRating', {
                        rating: rating,
                        post_id: this.post_id,
                        post_type: this.post_type,
                    })
                        .then(res => {
                            this.isRating = rating+'_n';
                            this.rating_avg_ = res.data.rating_avg;
                            this.countall = res.data.total_votes;
                            this.likes_ = res.data.likes;
                        })
                        .catch(err => {
                            console.error(err);
                        }).then(() => {
                    })
                } else {
                    this.$swal({
                        icon: 'info',
                        text: 'Ви вже поставили оцінку',
                        showConfirmButton: false,
                    });
                }
            },
        }
    }
</script>

