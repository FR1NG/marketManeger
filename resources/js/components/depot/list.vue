<template>
  <v-container>
    <v-card>
      <v-data-table
        :headers="headers"
        :search="search"
        :items="items"
        :loading="loading"
        hide-default-footer
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>List Des Articles</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
          </v-toolbar>

          <v-card-title>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
              :loading="searchLoading"
            ></v-text-field>
          </v-card-title>
        </template>

        <!-- BEGIN:quantity column -->
        <template v-slot:item.items_in_warehouse_sum_quantity="{ item }">
          <div v-if="!item.items_in_warehouse_sum_quantity">
            <v-icon class="red--text"> mdi-alert-outline </v-icon>
          </div>
          <div v-else>{{ item.items_in_warehouse_sum_quantity }}</div>
        </template>
        <!-- END:action column -->
      </v-data-table>
      <!-- BEGIN:pagination -->
      <v-pagination
        v-model="currentPage"
        class="py-4"
        :length="lastPage"
        :total-visible="8"
      ></v-pagination>
      <!-- END:pagination -->
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        { text: "DSG", value: "name" },
        { text: "Catégorie", value: "category.name" },
        { text: "Unité", value: "unit.name" },
        { text: "Quantité en dépot", value: "items_in_warehouse_sum_quantity" },
        { text: "Quantité de notification", value: "notification_quantity" },
      ],
      searchLoading: false,
      loading: false,
    };
  },
  watch: {
    currentPage() {
      this.getData();
    },
    search() {
      this.handleSearch();
    },
  },
  computed: {
    items() {
      return this.$store.getters["article/articles"];
    },
    lastPage() {
      return this.$store.getters["article/lastPage"];
    },
    currentPage: {
      get() {
        return this.$store.getters["article/currentPage"];
      },
      set(value) {
        this.$store.commit("article/setCurrentPage", { page: value });
      },
    },
    search: {
      get() {
        return this.$store.getters["article/search"];
      },
      set(value) {
        this.$store.commit("article/setSearch", { search: value });
      },
    },
    createArticleDialog() {
      return this.$store.getters["article/createArticleDialog"];
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store
        .dispatch("article/getData")
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
    handleSearch() {
      this.searchLoading = true;
      if (this.timeout) clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
        //action
        this.$store
          .dispatch("article/getData")
          // promis resolved
          .then(() => {
            this.searchLoading = false;
          });
      }, 500); // delay
    },
    createArticle() {
      this.$store.commit("article/showCreateArticleDialog");
    },
    remove(id) {
      this.$store.commit("employe/setDelete", { id: id });
    },
    edit(employe) {
      // this.$router.replace({
      //   name: "modifierEmploye",
      //   params: {
      //     id: employe.id,
      //   },
      // });
      alert("Not setted yet");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>