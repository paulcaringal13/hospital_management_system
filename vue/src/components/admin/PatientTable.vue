<template>
  <div class="flex flex-row h-fit justify-between">
    <VaInput
      v-model="filter"
      class="sm:col-span-2 md:col-span-3"
      placeholder="Filter..."
    />
  </div>

  <div className="h-[85%]">
    <VaDataTable
      :items="items"
      :columns="columns"
      :per-page="perPage"
      :current-page="currentPage"
      :filter="filter"
      @filtered="filtered = $event.items"
      :height="auto"
    >
      <template #cell(actions)="{ rowIndex }">
        <button
          @click="openModalToEditItemById(rowIndex)"
          className="mr-4 rounded-md hover:bg-primary hover:shadow-lg hover:text-white px-2 py-1"
        >
          <v-icon name="ri-edit-line" scale="1.2" className="mb-1" />
        </button>
        <button
          @click="openModalToEditItemById(rowIndex)"
          className="mr-4 rounded-md hover:bg-red-400 hover:shadow-lg hover:text-white px-2 py-1"
        >
          <v-icon name="ri-delete-bin-7-line" scale="1.2" className="mb-1" />
        </button>
      </template>
    </VaDataTable>
  </div>
  <div class="flex mt-4 w-fit ml-auto">
    <VaPagination v-model="currentPage" :pages="pages" />
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    const users = [
      {
        id: 1,
        name: "Leanne Graham",
        username: "Bret",
        email: "Sincere@april.biz",
        phone: "1-770-736-8031 x56442",
        website: "hildegard.org",
      },
      {
        id: 2,
        name: "Ervin Howell",
        username: "Antonette",
        email: "Shanna@melissa.tv",
        phone: "010-692-6593 x09125",
        website: "anastasia.net",
      },
      {
        id: 3,
        name: "Clementine Bauch",
        username: "Samantha",
        email: "Nathan@yesenia.net",
        phone: "1-463-123-4447",
        website: "ramiro.info",
      },
      {
        id: 4,
        name: "Patricia Lebsack",
        username: "Karianne",
        email: "Julianne.OConner@kory.org",
        phone: "493-170-9623 x156",
        website: "kale.biz",
      },
      {
        id: 5,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 6,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 7,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 8,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 9,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 10,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 11,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
      {
        id: 12,
        name: "Chelsey Dietrich",
        username: "Kamren",
        email: "Lucio_Hettinger@annie.ca",
        phone: "(254)954-1289",
        website: "demarco.info",
      },
    ];

    const columns = [
      { key: "id", sortable: true, width: "50px" },
      { key: "username", sortable: true, width: "200px" },
      { key: "name", sortable: true, width: "300px" },
      { key: "email", sortable: true, width: "500px" },
      { key: "phone" },
      { key: "actions" },
    ];

    return {
      items: users,
      columns,
      perPage: 10,
      currentPage: 1,
      filter: "",
      filtered: users,
    };
  },
  methods: {
    openModalToEditItemById(id) {
      const patient = this.items[id];

      console.log(patient);
    },
  },
  computed: {
    pages() {
      return this.perPage && this.perPage !== 0
        ? Math.ceil(this.filtered.length / this.perPage)
        : this.filtered.length;
    },
  },
});
</script>
