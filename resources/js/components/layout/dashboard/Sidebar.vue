<template>
  <div class="flex shrink-0 w-64 h-full min-h-screen flex-col bg-gray-800 text-white">
    <div class="flex justify-between items-center p-4 mb-4">
      <span>{{ $store.state.user.name }}</span>
      <img src="/imgs/logout.png" alt="logout" class="w-8 invert cursor-pointer" @click="logout">
    </div>
    <div v-for="(route, index) in routes" :key="index">
      <div
        v-if="route.permission == '' || ($store.state.permissions && $store.state.permissions[route.permission])"
        class="p-4 cursor-pointer"
        :class="{'bg-black': $route.path.indexOf(route.path) == 0}"
        @click="redirectTo(route.path)"
      >
        <span>{{ route.label }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'sidebar-component',
  data() {
    return {
      routes: [
        {
          id: 'home',
          path: '/dashboard/home',
          label: 'Dashboard',
          permission: '',
        },
        {
          id: 'users',
          path: '/dashboard/users',
          label: 'Users',
          permission: 'App.Http.Controllers.Api.Dashboard.UserController',
        },
        {
          id: 'tests',
          path: '/dashboard/tests',
          label: 'Tests',
          permission: 'App.Http.Controllers.Api.Dashboard.TestController',
        },
        {
          id: 'user-roles',
          path: '/dashboard/user-roles',
          label: 'Roles',
          permission: 'App.Http.Controllers.Api.Dashboard.UserRoleController',
        },
        {
          id: 'permission-columns',
          path: '/dashboard/permission-columns',
          label: 'Permission Columns',
          permission: 'App.Http.Controllers.Api.Dashboard.PermissionColumnController',
        },
      ]
    }
  },
  methods: {
    redirectTo(path) {
      this.$router.push(path);
    },
    logout() {
      this.$store.commit('logout');
      this.$router.push('/auth');
    }
  }
}
</script>