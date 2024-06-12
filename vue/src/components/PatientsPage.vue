<template>
    <div v-if="loading">Loading...</div>
    <div className="h-full w-full flex flex-col" v-else>
        <NavbarComponent />
        <div className="flex flex-row grow w-auto">
            <SidebarComponent />
            <div className="flex flex-col m-5 w-full gap-2">
                <div className="flex w-full justify-between">
                    <h1 className="text-lg font-bold">Patients</h1>
                </div>
                <div className="bg-white grow w-full p-8 rounded-md shadow-md items-center justify-center text-center"
                    v-if="patients.length == 0">
                    Loading...
                </div>
                <div className="bg-white grow w-full p-8 rounded-md shadow-md" v-else>
                    <PatientTable :patients="patients" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarComponent from "./NavbarComponent.vue";
import SidebarComponent from "./SidebarComponent.vue";
import PatientTable from "./PatientTable.vue";

export default {
    name: "PatientsPage",
    components: {
        NavbarComponent,
        SidebarComponent,
        PatientTable,
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        patients() {
            return this.$store.getters.patients;
        },
        loading() {
            return this.$store.state.loading;
        },
    },
    beforeMount() {
        this.$store.dispatch("getPatients");
        this.$store.dispatch("getUser", localStorage.getItem("id"));
    },
};
</script>