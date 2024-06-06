// routes.js
import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../components/LoginPage.vue";
import RegisterPage from "../components/RegisterPage.vue";
import DoctorHome from "../components/doctor/DoctorHome.vue";
import PatientHome from "../components/patient/PatientHome.vue";
import AdminHome from "../components/admin/AdminHome.vue";

const routes = [
  //
  // ALL USER
  //

  // LOGIN ROUTE
  {
    path: "/",
    component: LoginPage,
    name: "login",
    // beforeEnter: (to, from, next) => {
    //   // check if user is logged in and redirect to login page if not
    //   if (localStorage.getItem("token")) {
    //     next(`/home/${localStorage.getItem("id")}`);
    //   } else {
    //     next();
    //   }
    // },
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
      console.log("logout");
      localStorage.removeItem("token");
      next("/");
    },
  },

  //
  // ADMIN USER ROUTES
  //

  // ADMIN HOME ROUTE
  {
    path: "/admin/home/:id",
    component: AdminHome,
    name: "admin-home",
    beforeEnter: guardRoute,
  },

  //
  // PATIENT USER ROUTES
  //

  // PATIENT HOME ROUTE
  {
    path: "/patient/home/:id",
    component: PatientHome,
    name: "patient-home",
    beforeEnter: guardRoute,
  },

  //
  // DOCTOR USER ROUTES
  //

  // DOCTOR HOME ROUTE
  {
    path: "/doctor/home/:id",
    component: DoctorHome,
    name: "doctor-home",
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
