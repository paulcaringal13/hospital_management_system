<template>
  <div className="shadow-md">
    <VaSidebar
      :minimized="this.minimized"
      minimized-width="64px"
      color="background"
    >
      <template v-for="item in items" :key="item.title">
        <VaSidebarItem
          :active="item.active"
          v-if="!minimized"
          @click="gotoPatients(item.route)"
        >
          <VaSidebarItemContent>
            <v-icon :name="item.icon" scale="1.1" className="mb-1" />
            <h1 className="text-xs font-semibold" v-if="!minimized">
              {{ item.title }}
            </h1>
          </VaSidebarItemContent>
        </VaSidebarItem>

        <VaSidebarItem :active="item.active" v-else>
          <VaPopover
            class="h-8 text-xs"
            placement="right"
            :message="item.title"
            closeOnFocusOutside="true"
            hoverOutTimeout="0"
            hoverOverTimeout="100"
            color="primary"
            textColor="white"
          >
            <VaSidebarItemContent>
              <v-icon :name="item.icon" scale="1.1" className="mb-1" />
            </VaSidebarItemContent>
          </VaPopover>
        </VaSidebarItem>
      </template>
    </VaSidebar>
  </div>
</template>

<script>
export default {
  name: "SidebarComponent",
  data() {
    return {
      items: [
        {
          title: "Patients",
          icon: "fa-user-injured",
          route: `/admin/patients/${localStorage.getItem("id")}`,
        },
        { title: "Doctors", icon: "fa-user-md" },
        { title: "Appointments", icon: "ri-calendar-2-line" },
        { title: "Records", icon: "fa-file-medical-alt" },
      ],
    };
  },
  computed: {
    minimized() {
      return this.$store.state.minimized;
    },
  },

  methods: {
    gotoPatients(route) {
      this.$router.push(route);
    },
  },
};
</script>
