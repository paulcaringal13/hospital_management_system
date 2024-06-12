<template>
  <div className=" w-[25%] px-6 py-8 rounded-lg shadow-md bg-white">
    <div className="flex flex-col gap-3 items-center w-auto">
      <h4 className="text-xl font-bold">Registration Form</h4>
      <form
        @submit.prevent="registerUser"
        className="w-full flex flex-col space-y-3"
      >
        <div className="form-group">
          <input
            type="text"
            className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
            id="name"
            v-model="name"
            @input="clearErrors('name')"
            placeholder="Enter name"
            required
          />
          <small class="text-red-400 font-semibold" v-if="errors.name">{{
            errors.name[0]
          }}</small>
        </div>
        <div class="form-group mb-3">
          <input
            type="email"
            className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
            id="email"
            v-model="email"
            @input="clearErrors('email')"
            placeholder="Enter email"
            required
          />
          <small class="text-red-400 font-semibold" v-if="errors.email">{{
            errors.email[0]
          }}</small>
        </div>
        <div class="form-group mb-3">
          <input
            type="password"
            className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
            id="password"
            v-model="password"
            @input="clearErrors('password')"
            placeholder="Password"
            required
          />
          <small class="text-red-400 font-semibold" v-if="errors.password">{{
            errors.password[0]
          }}</small>
        </div>
        <div class="form-group mb-3">
          <input
            type="password"
            className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
            id="confirm"
            v-model="confirm"
            placeholder="Confirm Password"
            required
          />
        </div>
        <div class="form-group mb-3">
          <input
            type="number"
            className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
            id="contact"
            v-model="contact"
            placeholder="Contact Number"
            required
          />
          <small class="text-red-400 font-semibold" v-if="errors.contact">{{
            errors.contact[0]
          }}</small>
        </div>
        <select
          className="form-control w-full px-3 py-3 text-xs border-b-[1px] border-black focus:outline-none"
          @change="setGender($event)"
        >
          <option selected className="text-gray-500">Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        <small class="text-red-400 font-semibold" v-if="errors.gender">{{
          errors.gender[0]
        }}</small>
        <input
          type="date"
          v-model="date_of_birth"
          class="border-b-[1px] border-black focus:outline-none block w-full px-3 py-3 text-xs"
        />
        <small class="text-red-400 font-semibold" v-if="errors.date_of_birth">{{
          errors.date_of_birth[0]
        }}</small>
        <button
          type="submit"
          className="bg-blue-500 h-full rounded-full text-white px-4 py-2"
        >
          Register
        </button>
      </form>
      <p className=" text-sm">
        Already have an account?
        <router-link to="/" className="text-blue-500">Login now!</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirm: "",
      contact: "",
      gender: "",
      date_of_birth: new Date(),
      errors: {},
    };
  },
  methods: {
    async registerUser() {
      try {
        const response = await axios.post(
          this.$root.$data.apiUrl + "/register",
          {
            name: this.name,
            email: this.email,
            password: this.password,
            gender: this.gender,
            password_confirmation: this.confirm,
            date_of_birth: this.date_of_birth,
            role: "Patient",
            contact: this.contact,
          }
        );
        if (response.status === 201) {
          this.name = "";
          this.email = "";
          this.password = "";
          this.gender = "";
          this.contact = "";
          this.date_of_birth = new Date();
          this.$router.push("/");
        }
      } catch (error) {
        this.errors = error.response.data.errors;
        this.name = "";
        this.email = "";
        this.password = "";
        this.gender = "";
        this.date_of_birth = new Date();
        this.contact = "";
      }
    },

    setGender(event) {
      this.gender = event.target.value;
    },
    clearErrors(field) {
      this.errors[field] = null;
    },
  },
};
</script>
