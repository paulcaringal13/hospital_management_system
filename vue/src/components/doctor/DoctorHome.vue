<template>
  <nav class="navbar">
    <div class="container d-flex justify-content-end">
      <ul class="nav">
        DOCTOR
        <router-link to="/logout" class="col-6">Logout</router-link>
      </ul>
    </div>
  </nav>
  <!-- the router view is where all the routes are rendered -->
  <router-view />
</template>

<script>
export default {
  name: "DoctorHome",
};
</script>
