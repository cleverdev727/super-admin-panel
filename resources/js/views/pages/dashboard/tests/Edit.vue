<template>
  <main class="relative overflow-y-auto py-6">
    <form @submit.prevent="saveTest">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <div class="md:flex md:items-center md:justify-between">
          <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Edit test row</h1>
          <button class="py-2 px-4 bg-red-600 text-sm text-white shadow-sm rounded-md" type="button" @click="deleteTestModal = true">Delete test row</button>
        </div>
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
              <button class="py-2 px-4 bg-green-600 text-sm text-white shadow-sm rounded-md">Edit test row</button>
            </span>
          </div>
        </div>
      </div>
    </form>
    <div v-show="deleteTestModal" class="fixed z-20 inset-0 overflow-y-auto">
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
          <div v-show="deleteTestModal" class="fixed inset-0 transition-opacity">
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
            v-show="deleteTestModal"
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
                  <h3 id="modal-headline" class="text-lg font-medium text-gray-900">Delete test row</h3>
                  <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500">
                      Are you sure you want to delete this test row?
                      This action cannot be undone.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button class="py-2 px-4 bg-red-600 text-sm text-white shadow-sm rounded-md mr-2 sm:mr-0" type="button" @click="deleteTest">Delete test row</button>
              <button class="py-2 px-4 bg-white text-sm border border-gray-300 shadow-sm rounded-md mr-0 sm:mr-2" type="button" @click="deleteTestModal = false">Cancel</button>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'test-edit-view',
  data() {
    return {
      pageId: 'tests',
      deleteTestModal: false,
      test: {
        name: null,
        email: null,
        description: null,
        status: 0,
        price: null,
      }
    }
  },
  mounted() {
    this.getTest();
  },
  methods: {
    getTest() {
      const self = this;
      axios.get(`api/dashboard/tests/${self.$route.params.id}`).then(function(response) {
        self.test = {...response.data};
      });
    },
    saveTest() {
      const self = this;
      axios.put(`api/dashboard/tests/${self.$route.params.id}`, self.test).then(function(response) {
        self.$notify({
          title: 'Success',
          text: 'Data updated correctly',
          type: 'success'
        });
        self.$router.push(`/dashboard/tests/${response.data.test.id}/edit`);
      });
    },
    deleteTest() {
      const self = this;
      axios.delete(`api/dashboard/tests/${self.$route.params.id}`).then(function(response) {
        self.$notify({
          title: 'Success',
          text: 'Data deleted successfully',
          type: 'success'
        });
        self.$router.push('/dashboard/tests');
      })
    }
  }
}
</script>