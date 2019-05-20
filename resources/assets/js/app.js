
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('question-component', require('./components/QuestionComponent.vue'));
Vue.component('user-follower-component', require('./components/UserFollowerComponent.vue'));
Vue.component('user-vote-component', require('./components/UserVoteComponent.vue'));
Vue.component('send-message-component', require('./components/SendMessageComponent.vue'));
Vue.component('avatar-component', require('./components/AvatarComponent.vue'));
Vue.component('comment-component', require('./components/CommentComponent.vue'));
Vue.component('bg-component',require('./components/BgComponent.vue'));
Vue.component('topic-component',require('./components/TopicComponent.vue'));
Vue.component('like-component',require('./components/LikeComponent.vue'));

const app = new Vue({
    el: '#app'
});
