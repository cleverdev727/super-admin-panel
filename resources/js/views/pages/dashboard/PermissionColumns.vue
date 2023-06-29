<template>
  <main class="relative overflow-y-auto py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Permission Columns</h1>
        <button class="py-2 px-4 bg-green-600 text-sm text-white shadow-sm rounded-md" @click="save">Save</button>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mt-6 shadow sm:rounded-lg">
        <div class="my-6 p-6 bg-white shadow overflow-hidden sm:rounded-md">
          <div v-for="(columns, tableName) in tables" :key="tableName">
            <h3 class="text-2xl mb-2">{{ tableName }}</h3>
            <div class="px-6">
              <div v-for="(column, index) in columns" :key="index" class="flex items-center">
                <input type="checkbox" :id="`${tableName}-${column}`" class="w-5 h-5 mr-2" @change="handleCheck(`${tableName}-${column}`)" :checked="isChecked(`${tableName}-${column}`)">
                <label :for="`${tableName}-${column}`" class="text-xl">{{ column }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'permission-columns-view',
  data() {
    return {
      tables: {},
      columns: [],
    }
  },
  mounted() {
    this.getTables();
    this.getColumns();
  },
  methods: {
    getTables() {
      const self = this;
      axios.get('api/dashboard/permission-columns/tables').then(function(response) {
        self.tables = response.data;
      });
    },
    getColumns() {
      const self = this;
      axios.get('/api/dashboard/permission-columns').then(function(response) {
        self.columns = response.data;
        console.log(self.columns);
      });
    },
    save() {
      const self = this;
      axios.post('/api/dashboard/permission-columns/save', {columns: this.columns}).then(function() {
        self.$notify({
          title: 'Success',
          text: 'Data saved correctly',
          type: 'success',
        })
      });
    },
    handleCheck(val) {
      let cloneColumns = [...this.columns];
      if(this.columns.includes(val)) {
        cloneColumns.splice(cloneColumns.indexOf(val), 1);
      } else {
        cloneColumns.push(val);
      }
      this.columns = [...cloneColumns];
      console.log(this.columns);
    },
    isChecked(val) {
      return this.columns.includes(val) ? true : false;
    }
  }
}
</script>