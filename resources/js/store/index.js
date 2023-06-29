import axios from 'axios';
import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      user: false,
      permissions: {},
      columnPermissions: {},
      settings: false,
    }
  },
  mutations: {
    setSetting(state, data) {
      state.settings = data;
    },
    login(state, response) {
      state.user = response.user;
      state.permissions = response.user.role.permissions;
      state.columnPermissions = response.user.role.column_permissions;
      localStorage.setItem('token', response.token);
      window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.token;
    },
    logout(state) {
      axios.post('api/auth/logout').then(function() {
        state.user = false;
      });
      delete window.axios.defaults.headers.common.Authorization;
      localStorage.removeItem('token');
    },
    setuser(state) {
      if (localStorage.getItem('token')) {
        axios.post('api/auth/user').then(function(response) {
          state.user = response.data;
          localStorage.setItem('userId', state.user.id);
          state.permissions = response.data.role.permissions;
          state.columnPermissions = response.data.role.column_permissions;
        })
      }
    },
    updateUser(state, response) {
      state.user = response;
      state.permissions = response.role.permissions;
      state.columnPermissions = response.role.column_permissions;
    }
  }
});

export default store;