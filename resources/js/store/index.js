import Vuex from 'vuex'
import Vue from 'vue'
import auth from './auth'
import app from './app'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    app
  }
})
