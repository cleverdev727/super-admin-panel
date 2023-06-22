<template>
  <form @submit.prevent="submit">
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="email">Email</p>
      <input type="text" id="email" v-model="user.email" placeholder="Email" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="password">Password</p>
      <input type="password" id="password" v-model="user.password" placeholder="password" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 text-right">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded outline-none">Sign In</button>
    </div>
    <p class="text-sm">
      Don't you have an account?
      <router-link class="align-baseline font-bold text-blue-500 hover:text-blue-700" to="/auth/register">Create account</router-link>
    </p>
  </form>
</template>

<script>
export default {
  name: 'login-view',
  data() {
    return {
      user: {
        email: null,
        password: null,
      }
    }
  },
  methods: {
    submit() {
      this.login();
    },
    login() {
      const self = this;
      axios.post('api/auth/login', this.user).then(function(response) {
        this.$store.commit('login', response.data);
        this.$router.push('/dashboard/home');
      }).catch(function(err) {
        self.user.password = null
      })
    }
  }
}
</script>