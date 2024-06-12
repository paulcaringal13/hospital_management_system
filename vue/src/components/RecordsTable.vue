<template>
    <!-- FILTER -->
    <div class="flex flex-row h-fit w-full justify-between mb-2">
      <VaInput
        v-model="filter"
        class="sm:col-span-2 md:col-span-3"
        placeholder="Filter..."
      />
    </div>
  
    <!-- TABLE -->
    <div className="h-[85%]">
      <VaDataTable
        :items="records"
        :columns="columns"
        :per-page="perPage"
        :current-page="currentPage"
        :filter="filter"
        @filtered="filtered = $event.items"
        :striped="true"
        :hide-default-header="true"
      >
        <!-- HEADER -->
        <template #headerAppend>
          <tr className="text-xs">
            <th
              v-for="key in Object.keys(columns)"
              :key="key"
              class="text-start px-2 py-3 text-primary"
            >
              {{ columns[key].key.toUpperCase() }}
            </th>
          </tr>
        </template>
  
        <!-- ACTION EDIT AND DELETE BUTTON -->
        <template #cell(actions)="{ rowIndex }">
          <button
            @click="openViewModal(rowIndex)"
            className="mr-4 rounded-md hover:bg-primary hover:shadow-lg hover:text-white px-2 py-1"
          >
            <v-icon name="ri-eye-line" scale="1.2" className="mb-1" />
          </button>
          <button
            @click="openEditModal(rowIndex)"
            className="mr-4 rounded-md hover:bg-green-400 hover:shadow-lg hover:text-white px-2 py-1"
            v-if="this.role == 'Doctor'"
          >
            <v-icon name="ri-edit-line" scale="1.2" className="mb-1" />
          </button>
        </template>
      </VaDataTable>
    </div>
  
    <!-- PAGINATION -->
    <div class="flex mt-4 w-fit ml-auto">
      <VaPagination v-model="currentPage" :pages="pages" />
    </div>
  
    <!-- VIEW MODAL -->
    <VaModal v-model="isViewModalOpen" hide-default-actions size="large">
      <div class="flex flex-col items-start gap-2">
        <h1 class="text-2xl font-semibold">
          {{ this.patient.name }} appointment
        </h1>
        <div className="grid grid-cols-3 w-full">
          <label for="name" className="col-span-1">Doctor Name:</label>
          <p className="col-span-2">
            {{ this.doctor?.name }} ({{ this.doctor?.specialization }})
          </p>
          <label for="schedule" className="col-span-1">Schedule:</label>
          <p className="col-span-2">{{ this.dateString }}</p>
          <label for="status" className="col-span-1">Status:</label>
          <p className="col-span-2">{{ this.status }}</p>
          <label for="remarks" className="col-span-1">Remarks:</label>
          <p className="col-span-2 ">{{ this.remarks }}</p>
        </div>
      </div>
    </VaModal>
  
    <!-- EDIT MODAL -->
    <VaModal v-model="isEditModalOpen" hide-default-actions size="large">
      <div class="flex flex-col items-start gap-1">
        <h1 class="va-h3">Appointment for {{ this.patient.name }}</h1>
        <div className="grid grid-cols-3 w-full">
          <label for="email" className="col-span-1">Doctor Name:</label>
          <p className="col-span-2">
            {{ this.doctor?.name }} ({{ this.doctor?.specialization }})
          </p>
          <label for="specialization" className="col-span-1">Status:</label>
          <p className="col-span-2">{{ this.status }}</p>
        </div>
        <label for="specialization" className="col-span-1">Remarks:</label>
        <textarea
          v-model="remarks"
          placeholder="Add remarks here..."
          className="border-[1px] border-zinc-200 w-full h-[150px] px-2 py-1 shadow-md rounded-md"
        />
      </div>
  
      <div class="flex justify-end mt-4 gap-2">
        <button
          className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
          @click="handleClose()"
        >
          Cancel
        </button>
        <button
          @click="this.isConfirmEditModalOpen = true"
          className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
        >
          Save
        </button>
      </div>
    </VaModal>
  
    <!-- EDIT CONFIRM MODAL-->
    <VaModal v-model="isConfirmEditModalOpen" hide-default-actions size="small">
      <h1 className="mt-2 mb-6">Are you sure you want to save the changes?</h1>
  
      <div class="flex justify-end mt-2 gap-2">
        <button
          @click="this.isConfirmEditModalOpen = false"
          className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
        >
          Cancel
        </button>
        <button
          @click="updateRecord()"
          className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
        >
          Yes
        </button>
      </div>
    </VaModal>
  
    <!-- DELETE MODAL MODAL -->
    <VaModal v-model="isDeleteModalOpen" hide-default-actions size="small">
      <h1 className="mt-2 mb-6">
        Are you sure you want to cancel your appointment?
      </h1>
  
      <div class="flex justify-end mt-2 gap-2">
        <button
          @click="handleClose()"
          className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
        >
          Cancel
        </button>
        <button
          @click="cancelAppointment()"
          className="text-white bg-red-400 hover:bg-red-400/75 px-4 py-2 rounded-md shadow-md"
        >
          Delete
        </button>
      </div>
    </VaModal>
  </template>
  
  <script>
  export default {
    props: {
      records: Array,
    },
    data() {
      const columns = [
        { key: "patient", width: "200px" },
        { key: "doctor", width: "200px" },
        { key: "schedule", width: "250px" },
        { key: "status" },
        { key: "actions" },
      ];
  
      return {
        //
        // TABLE
        //
        items: this.records,
        columns,
        perPage: 10,
        currentPage: 1,
        filter: "",
        filtered: this.records,
  
        //
        // MODALS
        //
        isViewModalOpen: false,
        isAddModalOpen: false,
        isConfirmAddModalOpen: false,
        isEditModalOpen: false,
        isConfirmEditModalOpen: false,
        isDeleteModalOpen: false,
  
        //
        // APPOINTMENTS
        //
        id: 0,
        doctor_id: "",
        patient_id: "",
        doctod: {},
        patient: {},
        appointment_time: "",
        status: "",
        date: "",
        dateString: new Date().toDateString(),
        time: "00:00",
        remarks: "",
      };
    },
    methods: {
      //
      // ACTIONS
      //
  
      // UPDATE
      async updateRecord() {
        const record = {
          id: this.id,
          remarks: this.remarks,
        };
  
        await this.$store
          .dispatch("updateRecord", record)
          .then((res) => {
            if (res) {
              this.items = this.$store.getters.records;
  
              this.$vaToast.init({
                message: Remarks edited successfully!,
                title: "Success",
                position: "bottom-right",
                color: "success",
                duration: 2500,
                icon: "",
              });
              this.isConfirmEditModalOpen = false;
              this.handleClose();
            }
          })
          .catch((error) => {
            this.isConfirmEditModalOpen = false;
  
            console.log(error);
          });
      },
  
      //
      // MODAL FUNCTIONS
      //
      openViewModal(index) {
        const record = this.items[index];
  
        this.isViewModalOpen = true;
        this.dateString = new Date(record.schedule).toDateString();
        this.doctor = { ...record.doctor_info };
        this.patient = { ...record.patient_info };
        this.status = record.status;
        this.remarks = record.remarks;
  
        console.log(record.remarks);
      },
      openAddModal() {
        this.isAddModalOpen = true;
      },
      openConfirmAddModal() {
        this.isConfirmAddModalOpen = true;
      },
      openEditModal(index) {
        const record = this.items[index];
  
        this.isEditModalOpen = true;
  
        this.id = record.id;
        this.dateString = new Date(record.schedule).toDateString();
        this.doctor = { ...record.doctor_info };
        this.patient = { ...record.patient_info };
        this.remarks = record.remarks;
        this.status = record.status;
      },
      openDeleteModal(index) {
        const { id } = this.items[index];
  
        this.id = id;
        this.isDeleteModalOpen = true;
      },
  
      // HANDLERS
      handleClose() {
        this.isViewModalOpen = false;
        this.isAddModalOpen = false;
        this.isEditModalOpen = false;
        this.isDeleteModalOpen = false;
        this.doctor = {};
        this.patient = {};
        this.appointment_time = "";
        this.status = "";
        this.date = "";
        this.dateString = new Date().toDateString();
        this.time = "00:00";
        this.remarks = "";
        this.$store.commit("clearErrors");
      },
      handleConfirmClose() {
        this.isConfirmEditModalOpen = false;
      },
      handleSelectDoctor(id) {
        this.doctor_id = id;
      },
      handleDate() {
        const date = new Date(this.date).toDateString();
  
        this.dateString = date;
      },
      setGender(event) {
        this.gender = event.target.value;
      },
      formatDate(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, "0");
        const day = String(d.getDate()).padStart(2, "0");
        return ${year}-${month}-${day};
      },
      formatTime(time) {
        return time ? ${time}:00 : "";
      },
      clearErrors(field) {
        this.errors[field] = null;
      },
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      doctors() {
        return this.$store.getters.doctors;
      },
      role() {
        return localStorage.getItem("role");
      },
      errors() {
        return this.$store.getters.errors;
      },
      pages() {
        return this.perPage && this.perPage !== 0
          ? Math.ceil(this.filtered.length / this.perPage)
          : this.filtered.length;
      },
    },
    mounted() {
      this.$store.dispatch("getUser", localStorage.getItem("id"));
    },
  };
  </script>