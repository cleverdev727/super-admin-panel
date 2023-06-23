<template>
  <div class="h-screen flex overflow-hidden">
    <Sidebar />
    <main class="relative w-full overflow-y-auto p-6">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import Sidebar from '../../components/layout/dashboard/Sidebar.vue';

export default {
    name: "dashboard-layout-view",
    components: { Sidebar }
}
</script>