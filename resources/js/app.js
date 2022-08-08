require('./bootstrap');
require('./my');

window.Vue = require('vue').default;

// календарь
import VCalendar from 'v-calendar';
Vue.use(VCalendar, {});

// подсказка
import FloatingVue from 'floating-vue'
import 'floating-vue/dist/style.css'
Vue.use(FloatingVue)

// попап
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// видео
import VueCoreVideoPlayer from 'vue-core-video-player'
Vue.use(VueCoreVideoPlayer)
// соц сети
import VueSocialSharing from 'vue-social-sharing'
Vue.use(VueSocialSharing);

Vue.component('CalendarAll', require('./components/CalendarAll.vue').default);
Vue.component('CalendarEvent', require('./components/CalendarEvent.vue').default);
Vue.component('Anecdote', require('./components/Anecdote.vue').default);
Vue.component('Word', require('./components/Word.vue').default);
Vue.component('Share', require('./components/Share.vue').default);
Vue.component('MyFavorites', require('./components/MyFavorites.vue').default);
Vue.component('PostsAll', require('./components/PostsAll.vue').default);

// Vue.component('Rating', require('./components/Rating.vue').default);
// Vue.component('LikeComponent', require('./components/loop/LikeComponent.vue').default);
Vue.component('RatingLike', require('./components/loop/RatingLike.vue').default);

export const eventBus = new Vue();
const app = new Vue({
    el: '#app',
});
