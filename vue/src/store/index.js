import { createStore } from "vuex";
import axiosClient from "../../axios/axios";

export default createStore({
  state: {
    user: {
      name: localStorage.getItem("name"),
      id: localStorage.getItem("id"),
      email: localStorage.getItem("email"),
    },
    patients: [],
    doctors: [],
    appointments: [],
    records: [],
    minimized: false,
    loading: true,
    errors: {},
  },
  mutations: {
    setUser(state, currentUser) {
      state.user = currentUser;
    },

    setPatients(state, patients) {
      const patientArr = patients.map((patient) => {
        const x = {
          ...patient,
          patient_id: patient.patient[0].id,
          gender: patient.patient[0].gender,
          birthday: patient.patient[0].date_of_birth,
        };

        delete x.patient;

        return x;
      });

      state.patients = patientArr;
    },

    setDoctors(state, doctors) {
      const doctorArr = doctors.map((doctor) => {
        const x = {
          ...doctor,
          doctor_id: doctor.doctor[0].id,
          specialization: doctor.doctor[0].specialization,
        };

        delete x.doctor;

        return x;
      });

      state.doctors = doctorArr;
    },

    setAppointments(state, appointments) {
      const appointmentsArr = appointments.map((appointment) => {
        const { appointment_time, id, status } = appointment;

        const doctor_info = {
          id: appointment.doctor.id,
          name: appointment.doctor.user.name,
          contact: appointment.doctor.user.contact,
          email: appointment.doctor.user.email,
          specialization: appointment.doctor.specialization,
        };

        const patient_info = {
          id: appointment.patient.id,
          name: appointment.patient.user.name,
          contact: appointment.patient.user.contact,
          email: appointment.patient.user.email,
          gender: appointment.patient.gender,
          birthday: appointment.patient.date_of_birth,
        };

        const x = {
          id: id,
          status: status,
          schedule: appointment_time,
          doctor: appointment.doctor.user.name,
          patient: appointment.patient.user.name,
          doctor_info: doctor_info,
          patient_info: patient_info,
        };

        return x;
      });

      console.log("====>", appointmentsArr);

      state.appointments = appointmentsArr;
    },

    setRecords(state, records) {
      const recordsArr = records.map((record) => {
        const { appointment_time, id, status, remarks } = record;

        const doctor_info = {
          id: record.doctor.id,
          name: record.doctor.user.name,
          contact: record.doctor.user.contact,
          email: record.doctor.user.email,
          specialization: record.doctor.specialization,
        };

        const patient_info = {
          id: record.patient.id,
          name: record.patient.user.name,
          contact: record.patient.user.contact,
          email: record.patient.user.email,
          gender: record.patient.gender,
          birthday: record.patient.date_of_birth,
        };

        const x = {
          id: id,
          status: status,
          schedule: appointment_time,
          doctor: record.doctor.user.name,
          patient: record.patient.user.name,
          doctor_info: doctor_info,
          patient_info: patient_info,
          remarks: remarks,
        };

        return x;
      });

      console.log("====>", recordsArr);

      state.records = recordsArr;
    },

    setMinimize(state) {
      state.minimized = !state.minimized;
    },

    setLoading(state, loading) {
      state.loading = loading;
    },

    clearErrors(state) {
      state.errors = {};
    },

    clearState(state) {
      state.patients = [];
      state.doctors = [];
      state.appointments = [];
      state.minimized = false;
      state.loading = true;
      state.errors = {};
    },
  },

  actions: {
    getUser({ commit }, user_id) {
      axiosClient
        .get(`/user/${user_id}`)
        .then((res) => {
          commit("setUser", res.data);
        })
        .catch((err) => console.log(err))
        .finally(() => {
          commit("setLoading", false);
        });
    },

    //
    // * PATIENTS
    //
    getPatients({ commit }) {
      axiosClient
        .get("/get/patients")
        .then((response) => {
          commit("setPatients", response.data);
        })
        .catch((error) => {
          console.error("Error fetching patients:", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    createPatient({ commit }, patient) {
      return new Promise((resolve, reject) => {
        axiosClient
          .post("/register", {
            name: patient.name,
            email: patient.email,
            password: patient.password,
            gender: patient.gender,
            password_confirmation: patient.confirm,
            date_of_birth: patient.date_of_birth,
            role: "Patient",
            contact: patient.contact,
          })
          .then((response) => {
            commit("setPatients", response.data.patients);

            resolve(response.data.patients);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    updatePatient({ commit }, patient) {
      return new Promise((resolve, reject) => {
        axiosClient
          .put(`/update/patients/${patient.id}, patient`)
          .then((response) => {
            commit("setPatients", response.data.patients);

            resolve(response.data.patients);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    deletePatient({ commit }, id) {
      return new Promise((resolve, reject) => {
        axiosClient
          .delete(`/delete/patients/${id}`)
          .then((response) => {
            commit("setPatients", response.data.patients);
            resolve(response.data.patients);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    //
    // * DOCTORS
    //
    getDoctors({ commit }) {
      axiosClient
        .get("/get/doctors")
        .then((response) => {
          console.log("get doctors response", response.data);
          commit("setDoctors", response.data);
        })
        .catch((error) => {
          console.error("Error fetching patients:", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    createDoctor({ commit }, doctor) {
      return new Promise((resolve, reject) => {
        axiosClient
          .post("/create/doctors", {
            name: doctor.name,
            email: doctor.email,
            password: doctor.password,
            password_confirmation: doctor.confirm,
            specialization: doctor.specialization,
            role: "Doctor",
            contact: doctor.contact,
          })
          .then((response) => {
            commit("setDoctors", response.data.doctors);

            resolve(response.data.doctors);
          })
          .catch((error) => {
            console.log(error);
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    updateDoctor({ commit }, doctor) {
      return new Promise((resolve, reject) => {
        axiosClient
          .put(`/update/doctors/${doctor.id}, doctor`)
          .then((response) => {
            commit("setDoctors", response.data.doctors);

            resolve(response.data.doctors);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    deleteDoctor({ commit }, id) {
      return new Promise((resolve, reject) => {
        axiosClient
          .delete(`/delete/doctors/${id}`)
          .then((response) => {
            commit("setDoctors", response.data.doctors);
            resolve(response.data.doctors);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    //
    // * APPOINTMENTS
    //
    getAppointments({ commit }) {
      axiosClient
        .get("/get/appointments")
        .then((response) => {
          commit("setAppointments", response.data);
        })
        .catch((error) => {
          console.error("===>", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    getOwnAppointments({ commit }) {
      axiosClient
        .get("/get/my-appointments")
        .then((response) => {
          commit("setAppointments", response.data);
        })
        .catch((error) => {
          console.error("===>", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    bookAppointment({ commit }, appointment) {
      return new Promise((resolve, reject) => {
        axiosClient
          .post("/book/appointments", appointment)
          .then((response) => {
            commit("setAppointments", response.data.appointments);

            resolve(response.data.appointments);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    cancelAppointment({ commit }, id) {
      return new Promise((resolve, reject) => {
        axiosClient
          .delete(`/delete/appointments/${id}`)
          .then((response) => {
            commit("setAppointments", response.data.appointments);
            resolve(response.data.appointments);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },

    //
    // * RECORDS
    //
    getRecords({ commit }) {
      axiosClient
        .get("/get/records")
        .then((response) => {
          commit("setRecords", response.data);
        })
        .catch((error) => {
          console.error("===>", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    getOwnRecords({ commit }) {
      axiosClient
        .get("/get/my-records")
        .then((response) => {
          commit("setRecords", response.data);
        })
        .catch((error) => {
          console.error("===>", error);
        })
        .finally(() => {
          commit("setLoading", false);
        });
    },

    updateRecord({ commit }, record) {
      return new Promise((resolve, reject) => {
        axiosClient
          .put(`/update/records/${record.id}, record`)
          .then((response) => {
            commit("setRecords", response.data.records);

            resolve(response.data.records);
          })
          .catch((error) => {
            this.state.errors = error.response.data.errors;

            reject(error);
          })
          .finally(() => {
            commit("setLoading", false);
          });
      });
    },
  },
  getters: {
    patients: (state) => state.patients,
    doctors: (state) => state.doctors,
    appointments: (state) => state.appointments,
    records: (state) => state.records,
    user: (state) => state.user,
    errors: (state) => state.errors,
  },
});

