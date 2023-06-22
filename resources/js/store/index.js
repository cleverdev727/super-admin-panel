import axios from 'axios';
import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      user: false,
      permissions: {},
      settings: false,
    }
  },
  mutations: {
    setSetting(state, data) {
      state.setting = data;
    },
    login(state, response) {
      state.user = response.user;
      // state.permissions = response.user.role.permissions;
      localStorage.setItem('token', response.token);
      window.axios.default.headers.common['Authorization'] = 'Bearer ' + response.token;
    },
    logout(state) {
      axios.post('api/auth/logout').then(function() {
        state.user = false;
      });
      delete window.axios.default.headers.common.Authorization;
      localStorage.removeItem('token');
    },
    setuser(state) {
      if (localStorage.getItem('token')) {
        axios.get('api/auth/user').then(function(response) {
          state.user = response.data;
          localStorage.setItem('userId', state.user.id);
          // state.permissions = response.data.role.permissions;
        })
      }
    },
    updateUser(state, response) {
      state.user = response;
      // state.permissions = response.role.permissions;
    }
  }
});

export default store;