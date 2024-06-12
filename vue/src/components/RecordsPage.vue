<template>
  <div v-if="loading">Loading...</div>
  <div className="h-full w-full flex flex-col" v-else>
    <NavbarComponent />
    <div className="flex flex-row grow w-auto">
      <SidebarComponent />
      <div className="flex flex-col m-5 w-full gap-2">
        <div className="flex w-full justify-between">
          <h1 className="text-lg font-bold">Records</h1>
        </div>
        <div
          className="bg-white grow w-full p-8 rounded-md shadow-md items-center justify-center text-center"
          v-if="loading == true"
        >
          Loading...
        </div>
        <div className="bg-white grow w-full p-8 rounded-md shadow-md" v-else>
          <RecordsTable :records="records" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarComponent from "./NavbarComponent.vue";
import SidebarComponent from "./SidebarComponent.vue";
import RecordsTable from "./RecordsTable.vue";

export default {
  name: "RecordsPage",
  components: {
    NavbarComponent,
    SidebarComponent,
    RecordsTable,
  },
  computed: {
    records() {
      return this.$store.getters.records;
    },
    loading() {
      return this.$store.state.loading;
    },
    role() {
      return localStorage.getItem("role");
    },
  },
  beforeMount() {
    if (this.role == "Admin") {
      this.$store.dispatch("getRecords");
    } else if (this.role == "Patient" || this.role == "Doctor") {
      this.$store.dispatch("getOwnRecords");
    }
  },
};
</script>
