import axios from 'axios'

export default {
  namespaced: true,
  state: {
    user: undefined
  },
  getters: {
    getUserInitials: state => {
      if (typeof state.user === 'object') {
        return state.user.name.slice(0, 1).toUpperCase() + state.user.surname.slice(0, 1).toUpperCase()
      }

      return '';
    },
    isAdmin: (state) => {
      return typeof state.user === 'object' && state.user.is_admin
    },
    isManager: (state) => {
      return typeof state.user === 'object' && (state.user.is_admin || state.user.is_manager)
    },
    getUser: state => {
      return state.user;
    },
    isAuth: state => {
      return typeof state.user === 'object' && state.user.id > 0;
    },
  },
  mutations: {
    setUser: (state, user) => {
      state.user = user;
    },
  },
  actions: {
    login: (state, options) => {
      return axios.post('api/login', options)
    },
    logout: (state) => {
      return axios.post('api/logout')
    },
    register: async (state, params) => {
      return await axios.post('api/register', params)
    },
    getUser: async (state) => {
      await axios
      .get('api/me')
      .then(response => {
        state.commit('setUser', response)
      })
    },
    isAuth: async (state) => {
      if (state.user === undefined) {
        await state.dispatch('getUser').then(() => {
        })
      }

      return state.getters['isAuth']
    },
    validateToken: async (state, token) => {
      return await axios
        .get('api/validate-token', {
          params: {
            token: token
          }
        })
    },
    validateLogin: (state, login) => {
      return axios
        .get('api/validate-login', {
          params: {
            login: login
          }
        })
    },
    sendResetPasswordLink: (state, email) => {
      return axios
        .post('api/send-reset-link',
        {
          "email": email
        })
    },
    resetPassword: (state, params) => {
      return axios
        .post('api/reset-password',
        params
      )
    }
  }
}
