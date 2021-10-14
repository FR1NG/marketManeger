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
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>List Des Fournisseur</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            link
            color="primary"
            dark
            class="mb-2"
            :to="{ name: 'ajouterFournisseur' }"
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
      <template v-slot:item.actions="{ item }">
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
        { text: "Nom", value: "name" },
        { text: "Email", value: "email" },
        { text: "Address", value: "address" },
        { text: "Tele", value: "phone" },
        { text: "Nbr d'operation", value: "achats_count" },
        { text: "Actions", value: "actions" },
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
      return this.$store.getters["fournisseur/items"];
    },
    lastPage() {
      return this.$store.getters["fournisseur/lastPage"];
    },
    currentPage: {
      get() {
        return this.$store.getters["fournisseur/currentPage"];
      },
      set(value) {
        this.$store.commit("fournisseur/setCurrentPage", { page: value });
      },
    },
    search: {
      get() {
        return this.$store.getters["fournisseur/search"];
      },
      set(value) {
        this.$store.commit("fournisseur/setSearch", { search: value });
      },
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store
        .dispatch("fournisseur/getData")
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
          .dispatch("fournisseur/getData")
          // promis resolved
          .then(() => {
            this.searchLoading = false;
          });
      }, 500); // delay
    },
    remove(id) {
      this.$store.commit("fournisseur/setDelete", { id: id });
    },
    edit(fournisseur) {
      this.$store.commit("fournisseur/setSelected", {
        fournisseur: fournisseur,
      });
      this.$router.replace({
        name: "modifierFournisseur",
        params: {
          id: fournisseur.id,
        },
      });
      console.log(fournisseur);
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>