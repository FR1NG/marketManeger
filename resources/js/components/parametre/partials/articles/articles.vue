<template>
  <v-container>
    <v-row>
      <!-- getgories:BEGIN -->
      <categories></categories>
      <!-- getgories:END -->
      <v-spacer></v-spacer>
      <v-divider class="mx-4" inset vertical></v-divider>

      <!-- units:BEGIN -->
      <units></units>
      <!-- units:END -->
    </v-row>
    <!-- create artice:BEGIN -->
    <create-article v-if="createArticleDialog"></create-article>
    <!-- create artice:END -->
    <!-- delete dialog:BEGIN -->
    <!-- <delete></delete> -->
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

          <v-btn color="primary" dark class="mb-2" @click="createArticle">
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
  </v-container>
</template>

<script>
import Categories from "../categories/categories.vue";
import Units from "../units/units.vue";
import CreateArticle from "./CreateArticle.vue";
// import Delete from "./delete.vue";
export default {
  components: {
    Categories,
    Units,
    CreateArticle,
    // Delete,
  },
  data() {
    return {
      headers: [
        { text: "DSG", value: "name" },
        { text: "Catégorie", value: "category.name" },
        { text: "Unité", value: "unit.name" },
        { text: "Quantité en dépot", value: "items_in_warehouse_sum_quantity" },
        { text: "Quantité de notification", value: "notification_quantity" },
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
      this.$router.replace({
        name: "modifierEmploye",
        params: {
          id: employe.id,
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