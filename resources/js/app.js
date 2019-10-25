require('./bootstrap');

import VueMq from 'vue-mq'
import store from './store'
import Vuelidate from 'vuelidate'

import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import feather from 'vue-icon'

window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const VMqOptions = {
  breakpoints: {
      mp: 415,
      mobile: 811.98,
      table: 1111.98,
      laptop: 1439.98,
      desktop: Infinity,
  },
  defaultBreakpoint: 'sm'
}

axios.defaults.baseURL = '/'

axios.interceptors.response.use((response) => {
    return response.data;
}, function (error) {
    if (error.response.status === 401 && Vue.$roter.meta.auth) {
        window.location.href = '/login'
    }

    if (error.response.status === 404) {
       router.push('/not_found')
    }

    if (error.response.status === 403) {
      store.dispatch('auth/getUser').then(() => {
        router.push({name: 'forbidden'})
      })
   }

    return Promise.reject(error.response);
});

Vue.use(VueMq, VMqOptions)
Vue.use(Vuelidate)

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(feather, {
  name: 'icon'
})

store
  .dispatch('auth/getUser')
  .then(() => {})
  .catch(() => {})
  .then(() => {
    const app = new Vue({
        el: '#content',
        router,
        store
    });    
  })