<template>
  <main class="relative overflow-y-auto py-6">
    <form @submit.prevent="saveUserRole">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Create user role</h1>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-6 shadow sm:rounded-lg">
          <div class="bg-white px-4 py-5 sm:p-6">
            <div class="flex pb-6 border-b border-gray-200 mb-6">
              <h3 class="w-1/3 text-lg font-medium text-gray-900">Role details</h3>
              <div class="w-2/3">
                <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
                <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Name" v-model="userRole.name" id="name">
              </div>
            </div>
            <div class="flex pb-6 border-b border-gray-200 mb-6">
              <div class="w-1/3">
                <h3 class="w-1/3 text-lg font-medium text-gray-900">Permissions</h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">Sections of the application protected with authentication.</p>
              </div>
              <div class="w-2/3">
                <div class="mt-1 flex rounded-md" v-for="(permissionKey, index) in permissionKeys" :key="index">
                  <span
                    :class="userRole.permissions.includes(permissionKey) ? 'bg-blue-600' : 'bg-gray-200'"
                    aria-checked="false"
                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-out duration-200"
                    role="checkbox"
                    @click="userRole.permissions.includes(permissionKey) ? userRole.permissions.splice(userRole.permissions.indexOf(permissionKey), 1) : userRole.permissions.push(permissionKey)"
                  >
                    <span
                      :class="userRole.permissions.includes(permissionKey) ? 'translate-x-5' : 'translate-x-0'"
                      aria-hidden="true"
                      class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
                    ></span>
                  </span>
                  <div class="ml-3 text-gray-800">{{ permissionLabels[permissionKey] }}</div>
                </div>
              </div>
            </div>
            <div class="flex">
              <div class="w-1/3">
                <h3 class="text-lg font-medium text-gray-900">Columns Access</h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">The checked columns will have permission.</p>
              </div>
              <div class="w-2/3">
                <div class="pr-28">
                  <div class="flex items-center rounded-md mb-2">
                    <span class="w-[150px]">Column Name</span>
                    <span class="w-[100px] text-center">No Access</span>
                    <span class="w-[100px] text-center">Read Only</span>
                    <span class="w-[100px] text-center">Read & Write</span>
                  </div>
                  <div class="mt-1 flex items-center rounded-md" v-for="(row, index) in columnRows" :key="index">
                    <span class="w-[150px]">{{ row.column }}</span>
                    <span class="w-[100px]">
                      <input type="radio" :name="row.column" class="ml-[42px] w-4 h-4" @change="handleCheck(row.id, 0)">
                    </span>
                    <span class="w-[100px]">
                      <input type="radio" :name="row.column" class="ml-[42px] w-4 h-4" @change="handleCheck(row.id, 1)">
                    </span>
                    <span class="w-[100px]">
                      <input type="radio" :name="row.column" class="ml-[42px] w-4 h-4" @change="handleCheck(row.id, 2)">
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
            <span class="inline-flex">
              <router-link
                class="py-2 px-4 bg-gray-400 text-sm text-white shadow-sm rounded-md mr-4"
                to="/dashboard/user-roles"
              >Cancel</router-link>
              <button class="py-2 px-4 bg-green-600 text-sm text-white shadow-sm rounded-md">Create user role</button>
            </span>
          </div>
        </div>
      </div>
    </form>
  </main>
</template>

<script>
export default {
  name: 'user-role-new-view',
  data() {
    return {
      permissionKeys: [],
      permissionLabels: [],
      userRole: {
        name: null,
        permissions: [],
        column_permissions: [],
      },
      columnRows: [],
    }
  },
  mounted() {
    this.getPermissions();
    this.getColumns();
  },
  methods: {
    saveUserRole() {
      const self = this;
      axios.post('api/dashboard/user-roles', self.userRole).then(function(response) {
        self.$notify({
          title: 'Success',
          text: 'Data saved correctly',
          type: 'success'
        });
        self.$router.push(`/dashboard/user-roles/${response.data.userRole.id}/edit`);
      });
    },
    getPermissions() {
      const self = this;
      axios.get('api/dashboard/user-roles/permissions').then(function(response) {
        self.permissionKeys = response.data.keys;
        self.permissionLabels = response.data.labels;
      });
    },
    getColumns() {
      const self = this;
      axios.get('/api/dashboard/user-roles/permission-columns').then(function(response) {
        self.columnRows = response.data;
      });
    },
    handleCheck(id, val) {
      let cloneColumnPermissions = [...this.userRole.column_permissions];
      if (cloneColumnPermissions.includes(`${id}-1`)) {
        cloneColumnPermissions.splice(cloneColumnPermissions.indexOf(`${id}-1`), 1);
      } else if (cloneColumnPermissions.includes(`${id}-2`)) {
        cloneColumnPermissions.splice(cloneColumnPermissions.indexOf(`${id}-2`), 1);
      }
      if (val > 0) {
        cloneColumnPermissions.push(`${id}-${val}`);
      }
      this.userRole.column_permissions = cloneColumnPermissions;
    }
  }
}
</script>