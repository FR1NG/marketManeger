<template>
  <v-card class="ma-4">
    <!-- delete dialog:BEGIN -->
    <delete></delete>
    <!-- delete dialog:END -->
    <v-data-table
      :headers="headers"
      :search="search"
      :items="items"
      :loading="loading"
      @click:row="gotoDetails"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>List Des Branchements</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            link
            color="primary"
            dark
            class="mb-2"
            :to="{ name: 'ajouterBranchements' }"
          >
            Ajouter
          </v-btn>
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

      <!-- BEGIN:action column -->
      <template v-slot:item.actions="{ item }" v-if="$hasRole('admin')">
        <v-btn color="info" @click.stop="edit(item)" icon text small>
          <v-icon>mdi-pencil-outline</v-icon>
        </v-btn>

        <v-btn color="error" @click.stop="remove(item.id)" icon text small>
          <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
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
</template>

<script>
import Delete from "./delete.vue";
export default {
  components: {
    Delete,
  },
  data() {
    return {
      headers: [
        { text: "№ contrt", value: "contract_number", sortable: false },
        { text: "Nom", value: "client_name", sortable: false },
        { text: "Adresse", value: "address", sortable: false },
        { text: "Ville", value: "city.name", sortable: false },
        {
          text: "Branchement",
          value: "market_article.display_name",
          sortable: false,
        },
        { text: "Intervention", value: "intervention", sortable: false },
        { text: "№ Devis", value: "estimate_number", sortable: false },
        { text: "№ Télephone", value: "phone", sortable: false },
        { text: "Date D'arriver", value: "arrival_date", sortable: false },
        { text: "Actions", value: "actions", sortable: false },
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
      return this.$store.getters["branchement/branchements"];
    },
    lastPage() {
      return this.$store.getters["branchement/lastPage"];
    },
    currentPage: {
      get() {
        return this.$store.getters["branchement/currentPage"];
      },
      set(value) {
        this.$store.commit("branchement/setCurrentPage", { page: value });
      },
    },
    search: {
      get() {
        return this.$store.getters["branchement/search"];
      },
      set(value) {
        this.$store.commit("branchement/setSearch", { search: value });
      },
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store
        .dispatch("branchement/getData")
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
          .dispatch("branchement/getData")
          // promis resolved
          .then(() => {
            this.searchLoading = false;
          });
      }, 500); // delay
    },
    remove(id) {
      this.$store.commit("branchement/setIdToDelete", { id });
    },
    edit(fournisseur) {
      alert("not setted yet");
    },
    gotoDetails(item) {
      this.$router.replace({
        name: "branchementDetails",
        params: {
          id: item.id,
        },
      });
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>