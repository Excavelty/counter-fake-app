/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('test', require('./components/test.vue').default);
Vue.component('add-post-form', require('./components/addPostForm.vue').default);
Vue.component('get-votes', require('./components/voteComponent.vue').default);
Vue.component('update-post', require('./components/updatePostForm.vue').default);
Vue.component('show-comments', require('./components/commentsComponent.vue').default);
Vue.component('get-media', require('./components/getMediaComponent.vue').default);
Vue.component('vote-component', require('./components/voteComponentAbleToVote.vue').default);
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const addPostForm = new Vue({
  el: '#addPostForm'
});

const getVotes = new Vue({
  el: '#getVotes'
});

const updatePost = new Vue({
  el: '#updatePost'
});

const showComments = new Vue({
  el: "#showComments"
});

const getMedia = new Vue({
  el: '#getMedia',
});

const voteComponent = new Vue({
  el: '#voteComponent',
})
