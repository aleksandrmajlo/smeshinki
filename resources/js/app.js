require('./bootstrap');

window.Vue = require('vue').default;

// видео
import VueCoreVideoPlayer from 'vue-core-video-player'
Vue.use(VueCoreVideoPlayer)
// соц сети
import VueSocialSharing from 'vue-social-sharing'
Vue.use(VueSocialSharing);

Vue.component('CalendarEvent', require('./components/CalendarEvent.vue').default);
Vue.component('Anecdote', require('./components/Anecdote.vue').default);
Vue.component('Word', require('./components/Word.vue').default);
Vue.component('Share', require('./components/Share.vue').default);
export const eventBus = new Vue();
const app = new Vue({
    el: '#app',
});
