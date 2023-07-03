<template>
  <main class="relative overflow-y-auto py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Users</h1>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
        <template v-if="userList.length > 0">
          <ul>
            <li v-for="(user, index) in userList" :key="index" class="border-t first:border-t-0 border-gray-200">
              <router-link :to="`/dashboard/users/${user.id}/edit`" class="block hover:bg-gray-100">
                <div class="flex items-center p-4 sm:px-6">
                  <div class="w-full md:grid md:grid-cols-2 md:gap-4">
                    <div>
                      <p class="text-sm font-medium text-blue-600 truncate" v-if="$displayColumn(`${pageId}-name`)">{{ user.name }}</p>
                      <p class="text-sm text-gray-500 truncate" v-if="$displayColumn(`${pageId}-email`)">{{ user.email }}</p>
                    </div>
                    <div class="hidden md:block">
                      <p class="text-sm text-gray-900 font-medium" v-if="$displayColumn(`${pageId}-role_id`)">
                        {{ user.role ? 'The user has the role: ' + user.role.name : 'The user doesn\'t have the role' }}
                      </p>
                      <p class="text-sm" :class="user.status === 1 ? 'text-gray-500' : 'text-red-500'" v-if="$displayColumn(`${pageId}-status`)">
                        {{ user.status === 1 ? 'User is activated' : 'User is disabled' }}
                      </p>
                    </div>
                  </div>
                </div>
              </router-link>
            </li>
          </ul>
        </template>
        <div class="hidden sm:block">
          <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <p class="text-sm text-gray-700">Showing {{ userList.length }} users</p>
          </nav>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'user-list-view',
  data() {
    return {
      pageId: 'users',
      userList: [],
    }
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      const self = this;
      axios.get('api/dashboard/users').then(function(response) {
        self.userList = response.data.items;
      });
    },
  }
}
</script>