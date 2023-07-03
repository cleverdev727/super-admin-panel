<template>
  <main class="relative overflow-y-auto py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Test page</h1>
        <router-link class="py-2 px-4 bg-blue-700 text-sm text-white shadow-sm rounded-md" to="/dashboard/tests/new">Create row</router-link>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 py-4 my-6 bg-white shadow overflow-hidden sm:rounded-md">
        <template v-if="rows.length > 0">
          <table class="w-full text-left text-sm font-light">
            <thead class="border-b font-medium">
              <tr>
                <template v-for="(header, index) in headers">
                  <th :key="index" class="px-6 py-4" v-if="$displayColumn(`${pageId}-${header.id}`)">
                    {{ header.label }}
                  </th>
                </template>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, index) in rows" :key="index" class="border-b hover:bg-neutral-100 cursor-pointer" @click="redirectToEdit(row.id)">
                <template v-for="(header, ind) in headers">
                  <td :key="ind" class="whitespace-nowrap px-6 py-4" v-if="$displayColumn(`${pageId}-${header.id}`)">
                    {{ row[header.id] }}
                  </td>
                </template>
              </tr>
            </tbody>
          </table>
        </template>
        <template v-else>
          No Data Found
        </template>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'test-list-view',
  data() {
    return {
      pageId: 'tests',
      headers: [
        { id: 'name', label: 'Name' },
        { id: 'email', label: 'Email' },
        { id: 'description', label: 'Description' },
        { id: 'status', label: 'Status' },
        { id: 'price', label: 'Price' },
      ],
      rows: [],
    }
  },
  mounted() {
    this.getRows();
  },
  methods: {
    getRows() {
      const self = this;
      axios.get('api/dashboard/tests').then(function(response) {
        self.rows = response.data.items;
      });
    },
    redirectToEdit(id) {
      this.$router.push(`/dashboard/tests/${id}/edit`);
    }
  }
}
</script>