<template>
  <!-- categories:BEGIN -->
  <v-col cols="12" md="6">
    <!-- create dialog:BEGIN -->
    <create-category v-if="createDialog"></create-category>
    <!-- create dialog:END -->

    <!-- edit dialog:BEGIN -->
    <edit-category v-if="editDialog"></edit-category>
    <!-- edit dialog:END -->

    <!-- delete dialog:BEGIN -->
    <delete-category></delete-category>
    <!-- delete dialog:END -->
    <v-data-table
      :headers="headers"
      :items="items"
      :loading="loading"
      :items-per-page="5"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Catégorie</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn icon color="primary" dark class="mb-2" @click="CreateCategory">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </v-toolbar>
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
  </v-col>
  <!-- categories:END -->
</template>


<script>
// import Delete from "./delete.vue";
import CreateCategory from "./CreateCategory.vue";
import DeleteCategory from "./DeleteCategory.vue";
import EditCategory from "./editCategory.vue";
export default {
  components: {
    // Delete,
    CreateCategory,
    EditCategory,
    DeleteCategory,
  },
  data() {
    return {
      headers: [
        { text: "Nom", value: "name" },
        { text: "Nombre d'article", value: "articles_count" },
        { text: "Actions", value: "actions" },
      ],
      loading: false,
    };
  },
  computed: {
    items() {
      return this.$store.getters["article/categories"];
    },
    // =======
    createDialog() {
      return this.$store.getters["article/createCategoryDialog"];
    },
    editDialog() {
      return this.$store.getters["article/editCategoryDialog"];
    },
  },
  methods: {
    remove(id) {
      this.$store.commit("article/setCategoryDelete", { id: id });
    },
    edit(category) {
      this.$store.commit("article/showEditCategoryDialog", {
        category: category,
      });
    },
    // ========
    CreateCategory() {
      this.$store.commit("article/showCreateCategoryDialog");
    },
  },
};
</script>

<style>
</style>