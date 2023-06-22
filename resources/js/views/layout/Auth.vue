<template>
  <div class="flex w-full h-full min-h-screen justify-center items-center">
    <div class="w-[500px] p-5 shadow-md border rounded-lg">
      <router-link class="flex justify-center items-center mb-8" to="/">
        <p class="text-2xl uppercase">Super Admin Panel</p>
      </router-link>
      <router-view/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'auth-layout-view'
}
</script>