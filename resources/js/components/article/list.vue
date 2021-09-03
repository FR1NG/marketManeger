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
          <v-toolbar-title>List Des Articles</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            link
            color="primary"
            dark
            class="mb-2"
            :to="{ name: 'ajouterArticles' }"
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
        { text: "DSG", value: "name" },
        { text: "Catégorie", value: "category" },
        { text: "Quantité en dépot", value: "quantity" },
        { text: "Quantité de notification", value: "minimum_quantity" },
        { text: "Actions", value: "actions" },
      ],
      searchLoading: false,
      loading : false,
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
      return this.$store.getters["employe/items"];
    },
    lastPage() {
      return this.$store.getters["employe/lastPage"];
    },
    currentPage: {
      get() {
        return this.$store.getters["employe/currentPage"];
      },
      set(value) {
        this.$store.commit("employe/setCurrentPage", { page: value });
      },
    },
    search: {
      get() {
        return this.$store.getters["employe/search"];
      },
      set(value) {
        this.$store.commit("employe/setSearch", { search: value });
      },
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store.dispatch("employe/getData")
      .then(()=>{
        this.loading = false;
      })
      .catch(()=>{
        this.loading = false;
      });
    },
    handleSearch() {
      this.searchLoading = true;
      if (this.timeout) clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
        //action
        this.$store
          .dispatch("employe/getData")
          // promis resolved
          .then(() => {
            this.searchLoading = false;
          });
      }, 500); // delay
    },
    remove(id) {
      this.$store.commit('employe/setDelete',{id : id});
    },
    edit(employe){
      this.$router.replace({
        name : 'modifierEmploye',
        params : {
          id : employe.id
        }
      })
    }
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>