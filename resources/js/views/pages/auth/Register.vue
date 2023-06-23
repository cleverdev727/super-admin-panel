<template>
  <form @submit.prevent="submit">
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="name">Name</p>
      <input type="text" id="name" v-model="user.name" placeholder="Name" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="email">Email</p>
      <input type="text" id="email" v-model="user.email" placeholder="Email" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="password">Password</p>
      <input type="password" id="password" v-model="user.password" placeholder="password" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 relative rounded-md shadow-sm">
      <p class="font-medium text-sm mb-1" for="password_confirmation">Confirm Password</p>
      <input type="password" id="password_confirmation" v-model="user.password_confirmation" placeholder="Confirm password" class="w-full px-4 py-2 border rounded-md" required>
    </div>
    <div class="mb-4 text-right">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded outline-none">Sign Up</button>
    </div>
    <p class="text-sm">
      Do you already have an account?
      <router-link class="align-baseline font-bold text-blue-500 hover:text-blue-700" to="/auth/login">Sign In</router-link>
    </p>
  </form>
</template>

<script>
export default {
  name: 'register-view',
  data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      }
    }
  },
  methods: {
    submit() {
      this.register();
    },
    register() {
      const self = this;
      axios.post('api/auth/register', this.user).then(function (response) {
        self.$notify({
          title: 'Success',
          text: 'Account created successfully',
          type: 'success'
        });
        self.$store.commit('login', response.data);
        self.$router.push('/dashboard/home');
      }).catch(function(err) {
        self.user.password = null;
        self.user.password_confirmation = null;
      })
    }
  }
}
</script>