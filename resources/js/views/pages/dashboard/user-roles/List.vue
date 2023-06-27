<template>
  <main class="relative overflow-y-auto py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">User roles</h1>
        <router-link class="py-2 px-4 bg-blue-700 text-sm text-white shadow-sm rounded-md" to="/dashboard/user-roles/new">Create user role</router-link>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
        <template v-if="userRoleList.length > 0">
          <ul>
            <li v-for="(userRole, index) in userRoleList" :key="index" class="border-t first:border-t-0 border-gray-200">
              <router-link :to="`/dashboard/user-roles/${userRole.id}/edit`" class="block hover:bg-gray-100">
                <div class="flex items-center p-4 sm:px-6">
                  <div class="w-full md:grid md:grid-cols-2 md:gap-4">
                    <span class="text-sm font-medium text-blue-600 truncate">{{ userRole.name }}</span>
                    <span class="hidden md:block text-sm text-gray-900 font-medium">{{ userRole.users }} assigned users</span>
                  </div>
                </div>
              </router-link>
            </li>
          </ul>
        </template>
        <div class="hidden sm:block">
          <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <p class="text-sm text-gray-700">Showing {{ userRoleList.length }} user roles</p>
          </nav>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'user-roles-list-view',
  data() {
    return {
      userRoleList: [],
    }
  },
  mounted() {
    this.getUserRoles();
  },
  methods: {
    getUserRoles() {
      const self = this;
      axios.get('api/dashboard/user-roles').then(function(response) {
        self.userRoleList = response.data.items;
      });
    }
  }
}
</script>