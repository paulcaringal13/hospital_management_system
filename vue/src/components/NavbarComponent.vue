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
      <div className=" mr-4">
        <VaDropdown>
          <template #anchor>
            <div>
              <button className="text-start text-xs font-semibold">
                Welcome! <br />
                <span v-if="loading == false">{{ user.name }},</span>
              </button>
            </div>
          </template>

          <VaDropdownContent>
            <div className="flex flex-col h-fit text-xs w-full gap-y-1">
              <button
                className="text-start text-xs font-semibold border-b-[1px] border-black pb-1"
                @click="openViewModal()"
                v-if="this.role == 'Patient' || this.role == 'Doctor'"
              >
                View Profile
              </button>
              <router-link
                to="/logout"
                @click="logoutUser()"
                className="text-start text-xs font-semibold"
                >Logout</router-link
              >
            </div>
          </VaDropdownContent>
        </VaDropdown>
      </div>
    </template>
  </VaNavbar>

  <!-- VIEW MODAL -->
  <VaModal v-model="isViewModalOpen" hide-default-actions size="small">
    <div class="flex flex-col items-start gap-2">
      <div className="flex flex-row justify-between w-full">
        <h1 class="va-h3">{{ this.name }}</h1>
        <button
          @click="this.isViewModalOpen = false"
          className=" hover:opacity-75 "
        >
          <v-icon name="ri-close-fill" scale="1.3" className="mb-1" />
        </button>
      </div>
      <div className="grid grid-cols-3 w-full" v-if="this.role == 'Patient'">
        <label for="email" className="col-span-1">Email:</label>
        <p className="col-span-2">{{ this.email }}</p>
        <label for="contact" className="col-span-1">Contact:</label>
        <p className="col-span-2">{{ this.contact }}</p>
        <label for="gender" className="col-span-1">Gender:</label>
        <p className="col-span-2">{{ this.gender }}</p>
        <label for="birthday" className="col-span-1">Birthday:</label>
        <p className="col-span-2">{{ this.birthday }}</p>
      </div>
      <div class="flex flex-col items-start gap-2" v-if="this.role == 'Doctor'">
        <div className="grid grid-cols-4 w-full">
          <label for="email" className="col-span-2">Email:</label>
          <p className="col-span-2">{{ this.email }}</p>
          <label for="contact" className="col-span-2">Contact:</label>
          <p className="col-span-2">{{ this.contact }}</p>
          <label for="specialization" className="col-span-2"
            >Specialization:</label
          >
          <p className="col-span-2">{{ this.specialization }}</p>
        </div>
      </div>
      <button
        className="w-fit px-4 py-2 ml-auto bg-primary shadow-md hover:bg-primary/75 text-white rounded-md"
        @click="openEditModal()"
      >
        Edit Account
      </button>
    </div>
  </VaModal>

  <!-- EDIT MODAL -->
  <VaModal v-model="isEditModalOpen" hide-default-actions size="large">
    <div class="flex flex-col items-start gap-1">
      <h1 class="va-h3">Edit Account</h1>
      <div className="w-full flex flex-col space-y-2">
        <div className="grid grid-cols-4 gap-x-2 gap-y-1">
          <label for="name" className="font-semibold col-span-2">Name:</label>
          <label for="email" className="font-semibold col-span-2">Email:</label>
          <div className="flex flex-col gap-2 col-span-2">
            <input
              type="text"
              className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg "
              id="name"
              v-model="name"
              placeholder="Enter name"
              required
            />
            <small class="text-red-400 font-semibold" v-if="errors.name">{{
              errors.name[0]
            }}</small>
          </div>
          <div className="flex flex-col gap-2 col-span-2">
            <input
              type="email"
              className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
              id="email"
              v-model="email"
              placeholder="Enter email"
              required
            />
            <small class="text-red-400 font-semibold" v-if="errors.email">{{
              errors.email[0]
            }}</small>
          </div>
          <label for="contact" className="font-semibold col-span-2"
            >Contact:</label
          >
          <label
            for="gender"
            className="font-semibold col-span-2"
            v-if="this.role == 'Doctor'"
            >Specialization:</label
          >
          <label
            for="gender"
            className="font-semibold col-span-2"
            v-if="this.role == 'Patient'"
            >Gender:</label
          >
          <div className="flex flex-col gap-2 col-span-2">
            <input
              type="number"
              className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
              id="contact"
              v-model="contact"
              placeholder="Enter contact number"
              required
            />
            <small class="text-red-400 font-semibold" v-if="errors.contact">{{
              errors.contact[0]
            }}</small>
          </div>
          <div
            className="flex flex-col gap-2 col-span-2"
            v-if="this.role == 'Doctor'"
          >
            <input
              type="text"
              className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg "
              id="specialization"
              v-model="specialization"
              placeholder="Enter specialization"
              required
            />
            <small
              class="text-red-400 font-semibold"
              v-if="errors.specialization"
              >{{ errors.specialization[0] }}</small
            >
          </div>
          <div
            className="flex flex-col gap-2 col-span-2"
            v-if="this.role == 'Patient'"
          >
            <div
              className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
            >
              <select
                className="w-full focus:outline-none"
                v-model="gender"
                @change="setGender($event)"
              >
                <option selected className="text-gray-500">Enter Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <small class="text-red-400 font-semibold" v-if="errors.gender">{{
              errors.gender[0]
            }}</small>
          </div>
          <label
            for="contact"
            className="font-semibold"
            v-if="this.role == 'Patient'"
            >Birthday:</label
          >
          <div
            className=" col-span-4 w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
            v-if="this.role == 'Patient'"
          >
            <input
              type="date"
              v-model="birthday"
              className="w-full focus:outline-none"
            />
          </div>
          <small
            class="text-red-400 font-semibold col-span-4"
            v-if="errors.date_of_birth"
            >{{ errors.date_of_birth[0] }}</small
          >
        </div>
      </div>
    </div>

    <div class="flex justify-end mt-4 gap-2">
      <button
        className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background"
        @click="this.isEditModalOpen = false"
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
        @click="updateDoctor()"
        v-if="this.role == 'Doctor'"
        className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
      >
        Yes
      </button>

      <button
        @click="updatePatient()"
        v-if="this.role == 'Patient'"
        className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md"
      >
        Yes
      </button>
    </div>
  </VaModal>
</template>

<script>
export default {
  name: "NavbarComponent",
  data() {
    return {
      isViewModalOpen: false,
      isEditModalOpen: false,
      isConfirmEditModalOpen: false,
      id: 0,
      name: "",
      email: "",
      contact: "",
      gender: "",
      birthday: "",
      specialization: "",
    };
  },
  methods: {
    logoutUser() {
      this.$store.commit("clearState");
    },
    setMinimize() {
      this.$store.commit("setMinimize");
    },
    openViewModal() {
      this.isViewModalOpen = true;
      const specialization = this.user.doctor?.[0]?.specialization ?? null;
      const gender = this.user.patient?.[0]?.gender ?? null;
      const date_of_birth = this.user.patient?.[0]?.date_of_birth ?? null;
      this.id = this.user.id;
      this.email = this.user.email;
      this.name = this.user.name;
      this.contact = this.user.contact;
      this.birthday = date_of_birth;
      this.gender = gender;
      this.specialization = specialization;
    },
    openEditModal() {
      this.isEditModalOpen = true;
      const specialization = this.user.doctor?.[0]?.specialization ?? null;
      const gender = this.user.patient?.[0]?.gender ?? null;
      const date_of_birth = this.user.patient?.[0]?.date_of_birth ?? null;

      this.id = this.user.id;
      this.email = this.user.email;
      this.name = this.user.name;
      this.contact = this.user.contact;
      this.birthday = date_of_birth;
      this.gender = gender;
      this.specialization = specialization;
    },

    async updateDoctor() {
      const doctor = {
        id: this.id,
        name: this.name,
        email: this.email,
        contact: this.contact,
        specialization: this.specialization,
      };

      await this.$store
        .dispatch("updateDoctor", doctor)
        .then((res) => {
          if (res) {
            this.items = this.$store.getters.doctors;

            this.$vaToast.init({
              message: `${this.name} account edited successfully!`,
              title: "Success",
              position: "bottom-right",
              color: "success",
              duration: 2500,
              icon: "",
            });
            this.isConfirmEditModalOpen = false;
            this.isEditModalOpen = false;
          }
        })
        .catch((error) => {
          this.isConfirmEditModalOpen = false;

          console.log(error);
        });
    },

    async updatePatient() {
      const patient = {
        id: this.id,
        name: this.name,
        email: this.email,
        contact: this.contact,
        gender: this.gender,
        date_of_birth: this.birthday,
      };

      await this.$store
        .dispatch("updatePatient", patient)
        .then((res) => {
          if (res) {
            this.items = this.$store.getters.patients;

            this.$vaToast.init({
              message: `${this.name} account edited successfully!`,
              title: "Success",
              position: "bottom-right",
              color: "success",
              duration: 2500,
              icon: "",
            });
            this.isConfirmEditModalOpen = false;
            this.isEditModalOpen = false;
          }
        })
        .catch((error) => {
          this.isConfirmEditModalOpen = false;

          console.log(error);
        });
    },
    setGender(event) {
      this.gender = event.target.value;
    },
    clearErrors(field) {
      this.errors[field] = null;
    },
  },
  computed: {
    role() {
      return localStorage.getItem("role");
    },
    user() {
      return this.$store.getters.user;
    },
    loading() {
      return this.$store.state.loading;
    },
    errors() {
      return this.$store.getters.errors;
    },
  },
  mounted() {
    this.$store.dispatch("getUser", localStorage.getItem("id"));
  },
};
</script>
