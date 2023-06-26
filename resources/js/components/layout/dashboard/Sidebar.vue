<template>
  <div class="flex shrink-0 w-64 h-full min-h-screen flex-col bg-gray-800 text-white">
    <div class="flex justify-between items-center p-4 mb-4">
      <span>{{ $store.state.user.name }}</span>
      <img src="/imgs/logout.png" alt="logout" class="w-8 invert cursor-pointer" @click="logout">
    </div>
    <div
      v-for="(route, index) in routes"
      :key="index"
      class="p-4 cursor-pointer"
      :class="{'bg-black': route.path == $route.path}"
      @click="redirectTo(route.path)"
    >
      <span>{{ route.label }}</span>
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
          permission: 'App.Http.Controllers.Api.Dashboard.HomeController',
        },
        {
          id: 'users',
          path: '/dashboard/users',
          label: 'Users',
          permission: 'App.Http.Controllers.Api.Dashboard.UserController',
        },
        {
          id: 'roles',
          path: '/dashboard/user-roles',
          label: 'Roles',
          permission: 'App.Http.Controllers.Api.Dashboard.RoleController',
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