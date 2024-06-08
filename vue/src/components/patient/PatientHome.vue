<template>
  <div className="h-full w-full flex flex-col">
    <NavbarComponent />
    <div className="flex flex-row grow">
      <SidebarComponent />
      <router-view />
    </div>
  </div>
</template>

<script>
import NavbarComponent from "../NavbarComponent.vue";
import SidebarComponent from "../SidebarComponent.vue";

export default {
  name: "AdminHome",
  components: {
    NavbarComponent,
    SidebarComponent,
  },
};
</script>
