<template>
    <!-- FILTER -->
    <div class="flex flex-row h-fit w-full justify-between mb-2">
        <VaInput v-model="filter" class="sm:col-span-2 md:col-span-3" placeholder="Filter..." />
        <button @click="openAddModal()"
            className="mr-4 rounded-md bg-primary text-sm shadow-md hover:bg-primary/75 px-3 py-2"
            v-if="this.role == 'Admin'">
            <v-icon name="fa-user-plus" scale="1.3" className="mb-1" />
            Add Patient
        </button>
    </div>

    <!-- TABLE -->
    <div className="h-[85%]">
        <VaDataTable :items="patients" :columns="columns" :per-page="perPage" :current-page="currentPage"
            :filter="filter" @filtered="filtered = $event.items" :striped="true" :hide-default-header="true">
            <!-- HEADER -->
            <template #headerAppend>
                <tr className="text-xs">
                    <th v-for="key in Object.keys(columns)" :key="key" class="text-start px-2 py-3 text-primary">
                        {{ columns[key].key.toUpperCase() }}
                    </th>
                </tr>
            </template>

            <!-- ACTION EDIT AND DELETE BUTTON -->
            <template #cell(actions)="{ rowIndex }">
                <button @click="openViewModal(rowIndex)"
                    className="mr-4 rounded-md hover:bg-primary hover:shadow-lg hover:text-white px-2 py-1">
                    <v-icon name="ri-eye-line" scale="1.2" className="mb-1" />
                </button>
                <button @click="openEditModal(rowIndex)"
                    className="mr-4 rounded-md hover:bg-primary hover:shadow-lg hover:text-white px-2 py-1"
                    v-if="this.role == 'Admin' || this.role == 'Doctor'">
                    <v-icon name="ri-edit-line" scale="1.2" className="mb-1" />
                </button>
                <button @click="openDeleteModal(rowIndex)"
                    className="mr-4 rounded-md hover:bg-red-400 hover:shadow-lg hover:text-white px-2 py-1"
                    v-if="this.role == 'Admin'">
                    <v-icon name="ri-delete-bin-7-line" scale="1.2" className="mb-1" />
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
            <h1 class="va-h3">{{ this.name }}</h1>
            <div className="grid grid-cols-3 w-full">
                <label for="email" className="col-span-1">Email:</label>
                <p className="col-span-2">{{ this.email }}</p>
                <label for="contact" className="col-span-1">Contact:</label>
                <p className="col-span-2">{{ this.contact }}</p>
                <label for="gender" className="col-span-1">Gender:</label>
                <p className="col-span-2">{{ this.gender }}</p>
                <label for="birthday" className="col-span-1">Birthday:</label>
                <p className="col-span-2">{{ this.birthday }}</p>
            </div>
        </div>
    </VaModal>

    <!-- ADD MODAL -->
    <VaModal v-model="isAddModalOpen" hide-default-actions size="large">
        <div class="flex flex-col items-start gap-1">
            <h1 class="va-h3">Create Patient Account</h1>
            <div className="w-full flex flex-col space-y-2">
                <div className="grid grid-cols-4 gap-x-2 gap-y-1">
                    <label for="name" className="font-semibold col-span-2">Name:</label>
                    <label for="email" className="font-semibold col-span-2">Email:</label>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="text"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg " id="name"
                            v-model="name" placeholder="Enter name" required />
                        <small class="text-red-400 font-semibold" v-if="errors.name">{{
                            errors.name[0]
                            }}</small>
                    </div>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="email"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg" id="email"
                            v-model="email" placeholder="Enter email" required />
                        <small class="text-red-400 font-semibold" v-if="errors.email">{{
                            errors.email[0]
                            }}</small>
                    </div>
                    <label for="password" className="font-semibold col-span-2">Password:</label>
                    <label for="confirm" className="font-semibold col-span-2">Confirm Password:</label>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="password"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg "
                            id="password" v-model="password" placeholder="Enter password" required />
                        <small class="text-red-400 font-semibold" v-if="errors.password">{{
                            errors.password[0]
                            }}</small>
                    </div>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="password"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg "
                            id="confirm" v-model="confirm" placeholder="Confirm Password" required />
                    </div>
                    <label for="contact" className="font-semibold col-span-2">Contact:</label>
                    <label for="gender" className="font-semibold col-span-2">Gender:</label>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="number"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
                            id="contact" v-model="contact" placeholder="Enter contact number" required />
                        <small class="text-red-400 font-semibold" v-if="errors.contact">{{
                            errors.contact[0]
                            }}</small>
                    </div>
                    <div className="flex flex-col gap-2 col-span-2">
                        <div className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg">
                            <select className="w-full focus:outline-none" @change="setGender($event)">
                                <option selected className="text-gray-500">Enter Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <small class="text-red-400 font-semibold" v-if="errors.gender">{{
                            errors.gender[0]
                            }}</small>
                    </div>

                    <label for="contact" className="font-semibold">Birthday:</label>
                    <div className=" col-span-4 w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg">
                        <input type="date" v-model="birthday" className="w-full focus:outline-none" />
                    </div>
                    <small class="text-red-400 font-semibold col-span-4" v-if="errors.date_of_birth">{{
                        errors.date_of_birth[0] }}</small>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 gap-2">
            <button className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background" @click="handleClose()">
                Cancel
            </button>
            <button @click="openConfirmAddModal()"
                className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md">
                Create
            </button>
        </div>
    </VaModal>

    <!-- ADD CONFIRM MODAL-->
    <VaModal v-model="isConfirmAddModalOpen" hide-default-actions size="small">
        <h1 className="mt-2 mb-6">Are you sure you want to create this account?</h1>

        <div class="flex justify-end mt-2 gap-2">
            <button @click="handleConfirmClose()" className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background">
                Cancel
            </button>
            <button @click="createPatient()"
                className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md">
                Yes
            </button>
        </div>
    </VaModal>

    <!-- EDIT MODAL -->
    <VaModal v-model="isEditModalOpen" hide-default-actions size="large">
        <div class="flex flex-col items-start gap-1">
            <h1 class="va-h3">Edit Patient Account</h1>
            <div className="w-full flex flex-col space-y-2">
                <div className="grid grid-cols-4 gap-x-2 gap-y-1">
                    <label for="name" className="font-semibold col-span-2">Name:</label>
                    <label for="email" className="font-semibold col-span-2">Email:</label>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="text"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg " id="name"
                            v-model="name" placeholder="Enter name" required />
                        <small class="text-red-400 font-semibold" v-if="errors.name">{{
                            errors.name[0]
                            }}</small>
                    </div>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="email"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg" id="email"
                            v-model="email" placeholder="Enter email" required />
                        <small class="text-red-400 font-semibold" v-if="errors.email">{{
                            errors.email[0]
                            }}</small>
                    </div>
                    <label for="contact" className="font-semibold col-span-2">Contact:</label>
                    <label for="gender" className="font-semibold col-span-2">Gender:</label>
                    <div className="flex flex-col gap-2 col-span-2">
                        <input type="number"
                            className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg"
                            id="contact" v-model="contact" placeholder="Enter contact number" required />
                        <small class="text-red-400 font-semibold" v-if="errors.contact">{{
                            errors.contact[0]
                            }}</small>
                    </div>
                    <div className="flex flex-col gap-2 col-span-2">
                        <div className="w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg">
                            <select className="w-full focus:outline-none" v-model="gender" @change="setGender($event)">
                                <option selected className="text-gray-500">Enter Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <small class="text-red-400 font-semibold" v-if="errors.gender">{{
                            errors.gender[0]
                            }}</small>
                    </div>

                    <label for="contact" className="font-semibold">Birthday:</label>
                    <div className=" col-span-4 w-full px-4 py-3 text-xs outline outline-1 focus:outline-2 rounded-lg">
                        <input type="date" v-model="birthday" className="w-full focus:outline-none" />
                    </div>
                    <small class="text-red-400 font-semibold col-span-4" v-if="errors.date_of_birth">{{
                        errors.date_of_birth[0] }}</small>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 gap-2">
            <button className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background" @click="handleClose()">
                Cancel
            </button>
            <button @click="openConfirmEditModal()"
                className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md">
                Save
            </button>
        </div>
    </VaModal>

    <!-- EDIT CONFIRM MODAL-->
    <VaModal v-model="isConfirmEditModalOpen" hide-default-actions size="small">
        <h1 className="mt-2 mb-6">Are you sure you want to save the changes?</h1>

        <div class="flex justify-end mt-2 gap-2">
            <button @click="handleConfirmClose()" className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background">
                Cancel
            </button>
            <button @click="updatePatient()"
                className="text-white bg-primary hover:bg-primary/75   px-4 py-2 rounded-md shadow-md">
                Yes
            </button>
        </div>
    </VaModal>

    <!-- DELETE MODAL MODAL -->
    <VaModal v-model="isDeleteModalOpen" hide-default-actions size="small">
        <h1 className="mt-2 mb-6">Are you sure you want to delete this account?</h1>

        <div class="flex justify-end mt-2 gap-2">
            <button @click="handleClose()" className="px-4 py-2 rounded-md hover:shadow-md hover:bg-background">
                Cancel
            </button>
            <button @click="deletePatient()"
                className="text-white bg-red-400 hover:bg-red-400/75 px-4 py-2 rounded-md shadow-md">
                Delete
            </button>
        </div>
    </VaModal>
</template>

<script>
export default {
    props: {
        patients: Array,
    },
    data() {
        const columns = [
            { key: "name", width: "150px" },
            { key: "email", width: "200px" },
            { key: "gender", width: "100px" },
            { key: "birthday", width: "125px" },
            { key: "contact" },
            { key: "actions" },
        ];

        return {
            //
            // TABLE
            //
            items: this.patients,
            columns,
            perPage: 10,
            currentPage: 1,
            filter: "",
            filtered: this.patients,

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
            // PATIENTS
            //
            id: 0,
            name: "",
            email: "",
            contact: "",
            password: "",
            confirm: "",
            gender: "",
            birthday: "",
        };
    },
    methods: {
        //
        // ACTIONS
        //

        // ADD
        async createPatient() {
            const patient = {
                name: this.name,
                email: this.email,
                contact: this.contact,
                password: this.password,
                confirm: this.confirm,
                gender: this.gender,
                date_of_birth: this.birthday,
            };

            await this.$store
                .dispatch("createPatient", patient)
                .then((res) => {
                    if (res) {
                        this.items = this.$store.getters.patients;

                        this.$vaToast.init({
                            message: ${ this.name } account created successfully!,
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

      // EDIT
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
                    message: ${ this.name } account edited successfully!,
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
          .catch ((error) => {
    this.isConfirmEditModalOpen = false;

    console.log(error);
});
      },

      // DELETE
      async deletePatient() {
    await this.$store
        .dispatch("deletePatient", this.id)
        .then((res) => {
            if (res) {
                this.items = this.$store.getters.patients;

                this.$vaToast.init({
                    message: Account deleted successfully!,
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
    const patient = this.items[index];
    this.isViewModalOpen = true;
    this.id = patient.id;
    this.email = patient.email;
    this.name = patient.name;
    this.contact = patient.contact;
    this.birthday = patient.birthday;
    this.gender = patient.gender;
},
openAddModal() {
    this.isAddModalOpen = true;
},
openConfirmAddModal() {
    this.isConfirmAddModalOpen = true;
},
openEditModal(index) {
    const patient = this.items[index];
    this.isEditModalOpen = true;
    this.id = patient.id;
    this.email = patient.email;
    this.name = patient.name;
    this.birthday = patient.birthday;
    this.gender = patient.gender;
    this.contact = patient.contact;
},
openConfirmEditModal() {
    this.isConfirmEditModalOpen = true;
},
openDeleteModal(index) {
    const { id } = this.items[index];

    this.id = id;
    this.isDeleteModalOpen = true;
},
handleClose() {
    this.isViewModalOpen = false;
    this.isAddModalOpen = false;
    this.isEditModalOpen = false;
    this.isDeleteModalOpen = false;
    this.id = 0;
    this.username = "";
    this.email = "";
    this.name = "";
    this.password = "";
    this.confirm = "";
    this.birthday = "";
    this.contact = "";

    this.$store.commit("clearErrors");
},
handleConfirmClose() {
    this.isConfirmEditModalOpen = false;
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
    errors() {
        return this.$store.getters.errors;
    },
    pages() {
        return this.perPage && this.perPage !== 0
            ? Math.ceil(this.filtered.length / this.perPage)
            : this.filtered.length;
    },
},
  };
</script>