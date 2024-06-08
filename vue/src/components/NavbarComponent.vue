<template>
  <VaNavbar color="primary" hideOnScroll="true">
    <template #left>
      <button
        @click="setMinimize()"
        className="mr-4 rounded-md hover:bg-secondary hover:shadow-lg px-2"
      >
        <v-icon name="ri-align-left" scale="1.2" className="mb-1" />
      </button>

      <div className="flex items-center ">
        <v-icon name="fa-accessible-icon" scale="1.8" className="my-auto" />
        <h1 class="text-2xl font-bold italic">C2D</h1>
      </div>
    </template>
    <template #right>
      <div className="flex flex-col w-fit h-fit text-xs">
        <h1>Admin,</h1>
        <router-link to="/logout" class="col-6">Logout</router-link>
      </div>
    </template>
  </VaNavbar>
</template>

<script>
export default {
  name: "NavbarComponent",
  methods: {
    setMinimize() {
      this.$store.commit("setMinimize");
    },
  },
};
</script>
