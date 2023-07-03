<template>
  <main class="relative overflow-y-auto py-6">
    <form @submit.prevent="saveTest">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Create test row</h1>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-6 shadow sm:rounded-lg">
          <div class="bg-white px-4 py-5 sm:p-6">
            <div class="flex border-gray-200">
              <h3 class="w-1/3 text-lg font-medium text-gray-900">Test details</h3>
              <div class="w-2/3">
                <div class="mb-4" v-if="$editColumn(`${pageId}-name`)">
                  <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
                  <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Name" v-model="test.name" id="name">
                </div>
                <div class="mb-4" v-if="$editColumn(`${pageId}-email`)">
                  <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                  <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Email" v-model="test.email" id="email">
                </div>
                <div class="mb-4" v-if="$editColumn(`${pageId}-description`)">
                  <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                  <input type="text" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Description" v-model="test.description" id="description">
                </div>
                <div class="mb-4" v-if="$editColumn(`${pageId}-status`)">
                  <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                  <select
                    name="status"
                    id="status"
                    class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm"
                    v-model="test.status"
                  >
                    <option value="0">Pending</option>
                    <option value="1">Processed</option>
                    <option value="2">Denied</option>
                  </select>
                </div>
                <div v-if="$editColumn(`${pageId}-price`)">
                  <label class="block text-sm font-medium text-gray-700" for="price">Price</label>
                  <input type="number" class="block h-10 px-4 border outline-none mt-1 rounded-md shadow-sm w-full text-sm" placeholder="Price" v-model="test.price" id="price">
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
            <span class="inline-flex">
              <router-link
                class="py-2 px-4 bg-gray-400 text-sm text-white shadow-sm rounded-md mr-4"
                to="/dashboard/tests"
              >Cancel</router-link>
              <button class="py-2 px-4 bg-green-600 text-sm text-white shadow-sm rounded-md">Create test row</button>
            </span>
          </div>
        </div>
      </div>
    </form>
  </main>
</template>

<script>
export default {
  name: 'test-new-view',
  data() {
    return {
      pageId: 'tests',
      test: {
        name: null,
        email: null,
        description: null,
        status: 0,
        price: null,
      }
    }
  },
  methods: {
    saveTest() {
      const self = this;
      axios.post('api/dashboard/tests', self.test).then(function(response) {
        self.$notify({
          title: 'Success',
          text: 'Data saved correctly',
          type: 'success'
        });
        self.$router.push(`/dashboard/tests/${response.data.test.id}/edit`);
      });
    }
  }
}
</script>