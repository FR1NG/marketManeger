<template>
  <v-container>
    <v-card>
      <v-data-table
        :headers="headers"
        :search="search"
        :items="items"
        :loading="loading"
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
        <template v-slot:item.quantity="{ item }">
          <div v-if="!item.quantity">
            <v-icon class="red--text"> mdi-alert-outline </v-icon>
          </div>
          <div
            v-else
            :class="
              item.quantity <= item.notification_quantity
                ? 'red--text font-weight-bold'
                : null
            "
          >
            {{ item.quantity }}
          </div>
        </template>
        <!-- END:action column -->
      </v-data-table>
      <!-- BEGIN:pagination -->
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
        { text: "Quantité en dépot", value: "quantity" },
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
      return this.$store.getters["depot/items"];
    },
    lastPage() {
      return this.$store.getters["depot/lastPage"];
    },
    currentPage: {
      get() {
        return this.$store.getters["depot/currentPage"];
      },
      set(value) {
        this.$store.commit("depot/setCurrentPage", { page: value });
      },
    },
    search: {
      get() {
        return this.$store.getters["depot/search"];
      },
      set(value) {
        this.$store.commit("depot/setSearch", { search: value });
      },
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store
        .dispatch("depot/getData")
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
          .dispatch("depot/getData")
          // promis resolved
          .then(() => {
            this.searchLoading = false;
          });
      }, 500); // delay
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>