<template>
  <div className="w-fit px-6 py-8 rounded-lg shadow-md bg-white">
    <div className="flex flex-col gap-3 w-fit items-center">
      <h4 className="text-xl font-bold">Login Account</h4>
      <form
        @submit.prevent="loginUser"
        className="w-full flex flex-col space-y-3"
      >
        <div className="form-group">
          <input
            type="email"
            className="form-control w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-full"
            id="email"
            v-model="email"
            placeholder="Enter email"
            required
          />
        </div>
        <div className="form-group">
          <input
            type="password"
            className="form-control w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-full"
            id="password"
            v-model="password"
            placeholder="Password"
            required
          />
        </div>
        <small className="text-red-500 mx-auto font-extrabold" v-if="errors">{{
          errors
        }}</small>

        <button
          type="submit"
          className="bg-blue-500 h-full rounded-full text-white px-4 py-2"
        >
          Login
        </button>
      </form>
      <p className=" text-sm">
        Don't have an account?
        <router-link to="/register" className="text-blue-500"
          >Register here!</router-link
        >
      </p>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
      errors: null,
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await axios.post(this.$root.$data.apiUrl + "/login", {
          email: this.email,
          password: this.password,
        });
        if (response.status === 201) {
          const { role_id, id } = response.data.user;

          localStorage.setItem("token", response.data.token);
          localStorage.setItem("id", id);
          localStorage.setItem("role_id", role_id);

          if (role_id === 1) {
            this.$router.push(`/admin/home/${id}`);
          } else if (role_id === 2) {
            this.$router.push(`/doctor/home/${id}`);
          } else {
            this.$router.push(`/patient/home/${id}`);
          }

          this.setCurrentUser(response.data.user);
        }
      } catch (error) {
        this.errors = error.response.data.message;
      }
    },
    setCurrentUser(user) {
      this.$store.commit("setUser", user);
    },
  },
};
</script>
