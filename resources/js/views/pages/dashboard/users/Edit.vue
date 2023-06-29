<template>
  <main class="relative overflow-y-auto py-6">
    <form @submit.prevent="saveUser">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <div class="md:flex md:items-center md:justify-between">
          <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Edit user</h1>
          <button class="py-2 px-4 bg-red-600 text-sm text-white shadow-sm rounded-md" type="button" @click="deleteUserModal = true">Delete user</button>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-6 shadow sm:rounded-lg">
          <div class="bg-white px-4 py-5 sm:p-6">
            <div class="flex pb-6 border-b border-gray-200 mb-6">
              <h3 class="w-1/3 text-lg font-medium text-gray-900">User details</h3>
              <div class="w-2/3">
                <div class="mb-4" v-if="displayColumn(`${pageId}-name`)">
                  <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
                  <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Name" v-model="user.name" id="name">
                </div>
                <div v-if="displayColumn(`${pageId}-email`)">
                  <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                  <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Email" v-model="user.email" id="email">
                </div>
              </div>
            </div>
            <div class="flex">
              <div class="w-1/3">
                <h3 class="w-1/3 text-lg font-medium text-gray-900">User Settings</h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">User access and permission settings</p>
              </div>
              <div class="w-2/3">
                <div class="mb-4" v-if="displayColumn(`${pageId}-role_id`)">
                  <label class="block text-sm font-medium text-gray-700" for="role">Role</label>
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <select
                      id="role"
                      v-model="user.role_id"
                      class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                      required
                    >
                      <option :value="null" disabled>Select an option</option>
                      <option v-for="(userRole, index) in userRoles" :key="index" :value="userRole.id">{{ userRole.name }}</option>
                    </select>
                  </div>
                </div>
                <div  v-if="displayColumn(`${pageId}-status`)">
                  <label class="block text-sm font-medium leading-5 text-gray-700" for="status">Status</label>
                  <div class="mt-1 flex rounded-md">
                    <span
                      :class="user.status ? 'bg-blue-600' : 'bg-gray-200'"
                      aria-checked="false"
                      class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-out duration-200"
                      role="checkbox"
                      @click="user.status = !user.status"
                    >
                      <span
                        :class="user.status ? 'translate-x-5' : 'translate-x-0'"
                        aria-hidden="true"
                        class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
                      ></span>
                    </span>
                    <div class="ml-3 text-gray-800">{{ user.status ? 'The user is activated' : 'The user is deactivated' }}</div>
                  </div>
                  <div class="mt-2 relative text-xs text-gray-500">
                    When the user is deactivated, the registry is created in the system, so the email is reserved, but can not login until it is activated again.
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
            <span class="inline-flex">
              <router-link
                class="py-2 px-4 bg-gray-400 text-sm text-white shadow-sm rounded-md mr-4"
                to="/dashboard/users"
              >Cancel</router-link>
              <button class="py-2 px-4 bg-green-600 text-sm text-white shadow-sm rounded-md">Edit user</button>
            </span>
          </div>
        </div>
      </div>
    </form>
    <div v-show="deleteUserModal" class="fixed z-20 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <transition
          duration="300"
          enter-active-class="ease-out duration-300"
          enter-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div v-show="deleteUserModal" class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
        </transition>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        <transition
          enter-active-class="ease-out duration-300"
          enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-show="deleteUserModal"
            aria-labelledby="modal-headline"
            aria-modal="true"
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog"
          >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <img src="/imgs/warning.png" alt="warning" class="h-8 w-6 pb-1">
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                    Delete user
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500">
                      Are you sure you want to delete the user?
                      All data will be permanently removed.
                      This action cannot be undone.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button
                class="py-2 px-4 bg-red-600 text-sm text-white shadow-sm rounded-md mr-2 sm:mr-0"
                type="button"
                @click="deleteUser"
              >
                Delete user
              </button>
              <button
                class="py-2 px-4 bg-white text-sm border border-gray-300 shadow-sm rounded-md mr-0 sm:mr-2"
                type="button"
                @click="deleteUserModal = false"
              >
                Cancel
              </button>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'user-edit-view',
  data() {
    return {
      pageId: 'users',
      deleteUserModal: false,
      userRoles: [],
      user: {
        name: null,
        email: null,
        role_id: null,
        status: true,
        password: null,
      }
    }
  },
  mounted() {
    this.getUserRoles();
    this.getUser();
  },
  methods: {
    saveUser() {
      const self = this;
      axios.put('api/dashboard/users/' + self.$route.params.id, self.user).then(function() {
        self.$notify({
          title: 'Success',
          text: 'Data updated correctly',
          type: 'success'
        });
      });
    },
    getUser() {
      const self = this;
      axios.get('api/dashboard/users/' + self.$route.params.id).then(function(response) {
        self.user = response.data;
      });
    },
    deleteUser() {
      const self = this;
      axios.delete('api/dashboard/users/' + self.$route.params.id).then(function() {
        self.$notify({
          title: 'Success',
          text: 'Data deleted successfully',
          type: 'success'
        });
        self.$router.push('/dashboard/users');
      }).catch(function() {
        self.deleteUserModal = false;
      });
    },
    getUserRoles() {
      const self = this;
      axios.get('api/dashboard/users/user-roles').then(function(response) {
        self.userRoles = response.data;
      });
    },
    displayColumn(col) {
      if (this.$store.state.columnPermissions[col] == undefined || this.$store.state.columnPermissions[col] == 2) {
        return true;
      } else {
        return false;
      }
    }
  }
}
</script>