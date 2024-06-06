<template>
  qweqweqwe
  <nav class="navbar bg-red-500">
    <div class="container d-flex justify-content-end">
      <ul class="nav">
        ADMIN
        <router-link to="/logout" class="col-6">Logout</router-link>
      </ul>
    </div>
  </nav>
  <router-view />
</template>

<script>
export default {
  name: "AdminHome",
};
</script>
