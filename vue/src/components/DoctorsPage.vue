<template>
  <div v-if="loading">Loading...</div>
  <div className="h-full w-full flex flex-col" v-else>
    <NavbarComponent />
    <div className="flex flex-row grow w-auto">
      <SidebarComponent />
      <div className="flex flex-col m-5 w-full gap-2">
        <div className="flex w-full justify-between">
          <h1 className="text-lg font-bold">Doctors</h1>
        </div>
        <div
          className="bg-white grow w-full p-8 rounded-md shadow-md items-center justify-center text-center"
          v-if="doctors.length == 0"
        >
          Loading...
        </div>
        <div className="bg-white grow w-full p-8 rounded-md shadow-md" v-else>
          <DoctorTable :doctors="doctors" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarComponent from "./NavbarComponent.vue";
import SidebarComponent from "./SidebarComponent.vue";
import DoctorTable from "./DoctorTable.vue";

export default {
  name: "PatientsPage",
  components: {
    NavbarComponent,
    SidebarComponent,
    DoctorTable,
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    doctors() {
      return this.$store.getters.doctors;
    },
    loading() {
      return this.$store.state.loading;
    },
  },
  beforeMount() {
    this.$store.dispatch("getDoctors");
    this.$store.dispatch("getUser", localStorage.getItem("id"));
  },
};
</script>