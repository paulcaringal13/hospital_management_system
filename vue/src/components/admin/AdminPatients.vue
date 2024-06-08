<template>
  <div className="h-full w-full flex flex-col">
    <NavbarComponent />
    <div className="flex flex-row grow w-auto">
      <SidebarComponent />
      <div className="flex flex-col m-5 w-full gap-2">
        <div className="flex w-full justify-between">
          <h1 className="text-lg font-bold">Patients</h1>
          <button
            @click="openModalToEditItemById(rowIndex)"
            className="mr-4 rounded-md bg-primary text-sm shadow-md hover:bg-primary/75 px-3 py-2"
          >
            <v-icon name="fa-user-plus" scale="1.3" className="mb-1" /> Add
            Patient
          </button>
        </div>
        <div className="bg-white grow w-full p-8 rounded-md shadow-md">
          <PatientTable />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarComponent from "../NavbarComponent.vue";
import SidebarComponent from "../SidebarComponent.vue";
import PatientTable from "./PatientTable.vue";

export default {
  name: "AdminPatients",
  components: {
    NavbarComponent,
    SidebarComponent,
    PatientTable,
  },
};
</script>
