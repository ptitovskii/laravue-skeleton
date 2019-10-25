import VueRouter from 'vue-router'
import Home from './pages/Home'

import Register from "./pages/Register"
import ForgotPassword from "./pages/ForgotPassword"
import ResetPassword from "./pages/ResetPassword"
import NotFound from "./pages/errors/NotFound"
import Forbidden from "./pages/errors/Forbidden"
import store from './store'


// Routes
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      auth: true
    }
  },
  {
    path: '/login',
    meta: {
      auth: false
    }
  },
  {
    path: '/register-by-token/:token',
    name: 'register_by_token',
    component: Register,
    meta: {
      title: 'Регистрация',
      auth: false
    },
    props: true
  },
  {
    path: '/forgot-password',
    name: 'forgot_password',
    component: ForgotPassword,
    meta: {
      title: '',
      auth: false
    },
  },
  {
    path: '/reset-password/:token/:email',
    name: 'reset_password',
    component: ResetPassword,
    meta: {
      title: 'Сброс пароля',
      auth: false
    },
    props: true
  },
  {
    path: '/403',
    name: 'forbidden',
    component: Forbidden,
    meta: {
      title: '',
    },
  },
  {
    path: '*',
    name: 'not_found',
    component: NotFound,
    meta: {
      title: '',
    },
  },
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.meta.auth === true) {
    console.log('1')
    if (!store.getters['auth/isAuth']) {
      return window.location.href = '/login'
    } else if (to.meta.manager && !(store.getters['auth/isAdmin'] || store.getters['auth/isManager'])) {
      return next({name: 'forbidden'})
    } else if (to.meta.admin && !store.getters['auth/isAdmin']) {
      return next({name: 'forbidden'})
    }
  } else if (to.meta.auth === false && store.getters['auth/isAuth']) {
    console.log('2')
    return next({name: 'home'})
  }

  document.title = store.getters['app/getAppName'] + (to.meta.title ? ' | ' + to.meta.title : '')

  return next()
})

export default router
