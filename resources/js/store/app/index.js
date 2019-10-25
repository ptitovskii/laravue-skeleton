import axios from 'axios'

export default {
  namespaced: true,
  state: {
  },
  getters: {
    getAppName: state => {
      return 'APP';
    },
  },
  mutations: {
  },
  actions: {
    getAppParams: async (state) => {
      await axios
        .get('api/get-params')
        .then(response => {
        })
        .catch(() => {});
    },

  }
}
