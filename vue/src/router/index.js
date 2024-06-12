// routes.js
import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../components/LoginPage.vue";
import RegisterPage from "../components/RegisterPage.vue";
import PatientsPage from "../components/PatientsPage.vue";
import DoctorsPage from "../components/DoctorsPage.vue";
import AppointmentsPage from "@/components/AppointmentsPage.vue";
import RecordsPage from "@/components/RecordsPage.vue";

const routes = [
  // LOGIN ROUTE
  {
    path: "/",
    component: LoginPage,
    name: "login",
  },

  // REGISTER ROUTE
  {
    path: "/register",
    component: RegisterPage,
    name: "register",
    beforeEnter: (to, from, next) => {
      // check if user is logged in and redirect to login page if not
      if (localStorage.getItem("token")) {
        next(`/home/${localStorage.getItem("id")}`);
      } else {
        next();
      }
    },
  },

  // LOGOUT ROUTE
  {
    path: "/logout",
    name: "logout",
    component: LoginPage,
    beforeEnter: (to, from, next) => {
      localStorage.removeItem("token");
      next("/");
    },
  },

  //
  //  * ADMIN USER ROUTES
  //

  // ADMIN PATIENTS ROUTE
  {
    path: "/admin/patients/:id",
    component: PatientsPage,
    name: "admin-patients",
    beforeEnter: guardRoute,
  },

  // ADMIN DOCTORS ROUTE
  {
    path: "/admin/doctors/:id",
    component: DoctorsPage,
    name: "admin-doctors",
    beforeEnter: guardRoute,
  },

  // ADMIN APPOINTMENTS ROUTE
  {
    path: "/admin/appointments/:id",
    component: AppointmentsPage,
    name: "admin-appointments",
    beforeEnter: guardRoute,
  },

  //  ADMIN RECORDS ROUTE
  {
    path: "/admin/records/:id",
    component: RecordsPage,
    name: "admin-records",
    beforeEnter: guardRoute,
  },

  //
  // * DOCTOR USER ROUTES
  //

  // DOCTOR PATIENTS ROUTE
  {
    path: "/doctor/patients/:id",
    component: PatientsPage,
    name: "doctor-patients",
    beforeEnter: guardRoute,
  },

  // DOCTOR APPOINTMENTS ROUTE
  {
    path: "/doctor/appointments/:id",
    component: AppointmentsPage,
    name: "doctor-appointments",
    beforeEnter: guardRoute,
  },

  // DOCTOR RECORDS ROUTE
  {
    path: "/doctor/records/:id",
    component: RecordsPage,
    name: "doctor-records",
    beforeEnter: guardRoute,
  },

  //
  // * PATIENT USER ROUTES
  //

  // PATIENT APPOINTMENTS ROUTE
  {
    path: "/patient/appointments/:id",
    component: AppointmentsPage,
    name: "patient-appointments",
    beforeEnter: guardRoute,
  },

  // PATIENT RECORDS ROUTE
  {
    path: "/patient/records/:id",
    component: RecordsPage,
    name: "patient-records",
    beforeEnter: guardRoute,
  },
];

function guardRoute(to, from, next) {
  if (localStorage.getItem("token")) {
    next();
  } else {
    next("/");
  }
}

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
