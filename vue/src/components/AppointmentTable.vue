<template>
  <!-- FILTER -->
  <div class="flex flex-row h-fit w-full justify-between mb-2">
    <VaInput
      v-model="filter"
      class="sm:col-span-2 md:col-span-3"
      placeholder="Filter..."
    />
    <button
      @click="openAddModal()"
      className="mr-4 rounded-md bg-primary text-sm shadow-md hover:bg-primary/75 px-3 py-2"
      v-if="this.role == 'Patient'"
    >
      <v-icon name="fa-book-medical" scale="1.3" className="mb-1" />

      Book Appointment
    </button>
  </div>

  <!-- TABLE -->
  <div className="h-[85%]">
    <VaDataTable
      :items="appointments"
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
          @click="openAppointmentCheckModal(rowIndex)"
          className="mr-4 rounded-md hover:bg-green-400 hover:shadow-lg hover:text-white px-2 py-1"
          v-if="this.role == 'Doctor'"
        >
          <v-icon name="ri-check-fill" scale="1.2" className="mb-1" />
        </button>
        <button
          @click="openDeleteModal(rowIndex)"
          className="mr-4 rounded-md hover:bg-red-400 hover:shadow-lg hover:text-white px-2 py-1"
          v-if="this.role == 'Patient' || this.role == 'Doctor'"
        >
          <v-icon name="ri-close-fill" scale="1.2" className="mb-1" />
        </button>
      </template>
    </VaDataTable>
  </div>

  <!-- PAGINATION -->
  <div class="flex mt-4 w-fit ml-auto">
    <VaPagination v-model="currentPage" :pages="pages" />
  </div>

  <!-- VIEW MODAL -->
  <VaModal v-model="isViewModalOpen" hide-default-actions size="small">
    <div class="flex flex-col items-start gap-2">
      <h1 class="text-2xl font-semibold">
        {{ this.patient.name }} appointment
      </h1>
      <div className="grid grid-cols-3 w-full">
        <label for="email" className="col-span-1">Doctor Name:</label>
        <p className="col-span-2">
          {{ this.doctor?.name }} ({{ this.doctor?.specialization }})
        </p>
        <label for="contact" className="col-span-1">Schedule:</label>
        <p className="col-span-2">{{ this.dateString }}</p>
        <label for="specialization" className="col-span-1">Status:</label>
        <p className="col-span-2">{{ this.status }}</p>
      </div>
    </div>
  </VaModal>

  <!-- ADD MODAL -->
  <VaModal v-model="isAddModalOpen" hide-default-actions size="xlarge">
    <h1 class="va-h3">Book Appointment</h1>
    <div
      className="grid grid-cols-3 space-x-2 border-[1px] border-zinc-200 rounded-md"
    >
      <div className="col-span-1 py-2 px-4">
        <h1 class="text-2xl font-bold mb-4">Your Information</h1>
        <div className="grid grid-cols-3">
          <h1 class="font-semibold col-span-1">Name:</h1>
          <p className="col-span-2">{{ this.user.name }}</p>
          <h1 class="font-semibold col-span-1">Contact:</h1>
          <p className="col-span-2">{{ this.user.contact }}</p>
          <h1 class="font-semibold col-span-1">Email:</h1>
          <p className="col-span-2">{{ this.user.email }}</p>
          <h1 class="font-semibold col-span-1">Gender:</h1>
          <p className="col-span-2">
            {{ this.user.patient[0]?.gender }}
          </p>
          <h1 class="font-semibold col-span-1">Birthday:</h1>
          <p className="col-span-2">
            {{ this.user.patient[0]?.date_of_birth }}
          </p>
        </div>
      </div>
      <div
        className="col-span-1  max-h-[500px] h-[400px] overflow-auto border-x-[1px] border-zinc-200  py-2 px-4"
      >
        <div>
          <h1 class="text-2xl font-bold mb-2">Available Doctors</h1>
          <small class="text-red-400 font-semibold" v-if="!!errors.doctor_id"
            >Please select a doctor.</small
          >
          <div
            className="grid grid-cols-5 items-center mb-3 text-sm pl-2 border-b-[1px] border-zinc-200 font-semibold italic mt-4"
          >
            <p className="col-span-2">NAME</p>
            <p className="col-span-2 mt-0">SPECIALIZATION</p>
          </div>
          <div
            v-for="doctor in this.doctors"
            :key="doctor.id"
            className="grid grid-cols-5 items-center mb-3 text-sm p-4 border-[1px] border-zinc-200 rounded-lg shadow-md "
          >
            <p className="col-span-2" v-if="this.doctor_id != doctor.doctor_id">
              {{ doctor.name }}
            </p>
            <p
              className="col-span-2 text-primary"
              v-if="this.doctor_id == doctor.doctor_id"
            >
              {{ doctor.name }}
            </p>

            <p className="col-span-2" v-if="this.doctor_id != doctor.doctor_id">
              {{ doctor.specialization }}
            </p>

            <p
              className="col-span-2 text-primary"
              v-if="this.doctor_id == doctor.doctor_id"
            >
              {{ doctor.specialization }}
            </p>

            <button
              className="bg-primary text-white py-1 px-2 hover:bg-primary/75 w-fit col-span-1 rounded-md shadow-md"
              @click="handleSelectDoctor(doctor.doctor_id)"
              v-if="this.doctor_id != doctor.doctor_id"
            >
              <v-icon name="fa-book-medical" scale="1" className="mb-1" />
            </button>

            <button
              className="bg-gray-800 text-white py-1 px-2 hover:bg-primary/75 w-fit col-span-1 rounded-md shadow-md"
              disabled
              v-if="this.doctor_id == doctor.doctor_id"
            >
              <v-icon name="fa-book-medical" scale="1" className="mb-1" />
            </button>
          </div>
        </div>
      </div>

      <div className="col-span-1  py-2 px-4">
        <h1 class="text-2xl font-bold mb-4">Choose Data and Time</h1>
        <div className="grid grid-cols-2">
          <div className="col-span-1 flex flex-col gap-4">
            <VaDatePicker
              v-model="date"
              @click="handleDate()"
              :allowed-days="(date) => date > new Date()"
            />

            <input
              type="time"
              v-model="time"
              className="p-1 px-2 shadow-none border-slate-800 border-[1px] rounded-sm"
            />
          </div>
          <div className="col-span-1 flex flex-col gap-4 text-center mt-16">
            <h1 className="font-semibold ">
              Selected Date: <br />{{ this.dateString }}
            </h1>
            <h1 className="font-semibold ">
              Selected Time: <br />{{ this.time }}
            </h1>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-end mt-4 gap-2">
      <button
        className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
        @click="handleClose()"
      >
        Cancel
      </button>
      <button
        @click="openConfirmAddModal()"
        className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
      >
        Create
      </button>
    </div>
  </VaModal>

  <!-- ADD CONFIRM MODAL-->
  <VaModal v-model="isConfirmAddModalOpen" hide-default-actions size="small">
    <h1 className="mt-2 mb-6 font-semibold">Book this appointment?</h1>

    <div class="flex justify-end mt-2 gap-2">
      <button
        @click="this.isConfirmAddModalOpen = false"
        className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
      >
        Cancel
      </button>
      <button
        @click="bookAppointment()"
        className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
      >
        Yes
      </button>
    </div>
  </VaModal>

  <!-- CHECK APPOINTMENT MODAL -->
  <VaModal
    v-model="isAppointmentCheckedModal"
    hide-default-actions
    size="large"
  >
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
        @click="this.isAppointmentSuccessModal = true"
        className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
      >
        Save
      </button>
    </div>
  </VaModal>

  <!-- SUCCESS MODAL -->
  <VaModal
    v-model="isAppointmentSuccessModal"
    hide-default-actions
    size="small"
  >
    <h1 className="mt-2 mb-6">Are you sure you want to save the changes?</h1>

    <div class="flex justify-end mt-2 gap-2">
      <button
        @click="this.isAppointmentSuccessModal = false"
        className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
      >
        Cancel
      </button>
      <button
        @click="finishAppointment()"
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
    appointments: Array,
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
      items: this.appointments,
      columns,
      perPage: 10,
      currentPage: 1,
      filter: "",
      filtered: this.appointments,

      //
      // MODALS
      //
      isViewModalOpen: false,
      isAddModalOpen: false,
      isConfirmAddModalOpen: false,
      isAppointmentCheckedModal: false,
      isAppointmentSuccessModal: false,
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
    async bookAppointment() {
      const formattedDateTime = `${this.formatDate(
        this.dateString
      )} ${this.formatTime(this.time)}`;

      const appointment = {
        doctor_id: this.doctor_id,
        patient_id: this.user.patient[0].id,
        appointment_time: formattedDateTime,
        status: "Booked",
      };

      await this.$store
        .dispatch("bookAppointment", appointment)
        .then((res) => {
          if (res) {
            this.items = this.$store.getters.appointments;

            this.$vaToast.init({
              message: `Appointment booked successfully!`,
              title: "Success",
              position: "bottom-right",
              color: "success",
              duration: 2500,
              icon: "",
            });
            this.isConfirmAddModalOpen = false;
            this.handleClose();
          }
        })
        .catch((error) => {
          this.isConfirmAddModalOpen = false;
          console.log(error);
        });
    },

    async cancelAppointment() {
      await this.$store
        .dispatch("cancelAppointment", this.id)
        .then((res) => {
          if (res) {
            this.items = this.$store.getters.appointments;

            this.$vaToast.init({
              message: `Appointment cancelled successfully!`,
              title: "Success",
              position: "bottom-right",
              color: "success",
              duration: 2500,
              icon: "",
            });
            this.handleClose();
          }
        })
        .catch((error) => {
          this.handleClose();
          console.log(error);
        });
    },

    async finishAppointment() {
      const formattedDateTime = `${this.formatDate(
        this.dateString
      )} ${this.formatTime(this.time)}`;

      const record = {
        status: "Finished",
        remarks: this.remarks,
        doctor_id: this.doctor.id,
        patient_id: this.patient.id,
        appointment_time: formattedDateTime,
        id: this.id,
      };

      await this.$store
        .dispatch("finishAppointment", record)
        .then((res) => {
          if (res) {
            this.items = this.$store.getters.appointments;

            this.$vaToast.init({
              message: `Appointment cancelled successfully!`,
              title: "Success",
              position: "bottom-right",
              color: "success",
              duration: 2500,
              icon: "",
            });
            this.handleClose();
          }
        })
        .catch((error) => {
          this.handleClose();
          console.log(error);
        });
    },

    //
    // MODAL FUNCTIONS
    //
    openViewModal(index) {
      const appointment = this.items[index];

      this.isViewModalOpen = true;
      this.dateString = new Date(appointment.schedule).toDateString();
      this.doctor = { ...appointment.doctor_info };
      this.patient = { ...appointment.patient_info };
      this.status = appointment.status;
    },
    openAddModal() {
      this.isAddModalOpen = true;
    },
    openConfirmAddModal() {
      this.isConfirmAddModalOpen = true;
    },
    openAppointmentCheckModal(index) {
      const appointment = this.items[index];

      this.isAppointmentCheckedModal = true;

      const sched = appointment.schedule.split(" ");

      this.id = appointment.id;
      this.dateString = new Date(sched[0]).toDateString();
      this.time = sched[1];
      this.doctor = { ...appointment.doctor_info };
      this.patient = { ...appointment.patient_info };
      this.status = appointment.status;
    },
    openDeleteModal(index) {
      const { id } = this.items[index];

      this.id = id;
      this.isDeleteModalOpen = true;
    },
    handleClose() {
      this.isViewModalOpen = false;
      this.isAddModalOpen = false;
      this.isAppointmentCheckedModal = false;
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

    formatDate(date) {
      const d = new Date(date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    },
    formatTime(time) {
      return time ? `${time}:00` : "";
    },

    setGender(event) {
      this.gender = event.target.value;
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
    this.$store.dispatch("getDoctors");
  },
};
</script>
