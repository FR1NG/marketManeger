<template>
  <!-- categories:BEGIN -->
  <v-col cols="12">
    <!-- create dialog:BEGIN -->
    <create-unit v-if="createDialog"></create-unit>
    <!-- create dialog:END -->

    <!-- edit dialog:BEGIN -->
    <edit-unit v-if="editDialog"></edit-unit>
    <!-- edit dialog:END -->

    <!-- delete dialog:BEGIN -->
    <delete-unit></delete-unit>
    <!-- delete dialog:END -->
    <v-data-table
      :headers="headers"
      :items="items"
      :loading="loading"
      :items-per-page="5"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Unités de mesure</v-toolbar-title>
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
import CreateUnit from "./CreateUnit.vue";
import EditUnit from "./editUnit.vue";
import DeleteUnit from "./DeleteUnit.vue";

export default {
  components: {
    CreateUnit,
    EditUnit,
    DeleteUnit,
  },
  data() {
    return {
      headers: [
        { text: "Nom", value: "name" },
        { text: "abréviation", value: "abr" },
        { text: "Actions", value: "actions" },
      ],
      loading: false,
    };
  },
  computed: {
    items() {
      return this.$store.getters["article/units"];
    },
    // =======
    createDialog() {
      return this.$store.getters["article/createUnitDialog"];
    },
    editDialog() {
      return this.$store.getters["article/editUnitDialog"];
    },
  },
  methods: {
    remove(id) {
      this.$store.commit("article/setUnitDelete", { id: id });
    },
    edit(unit) {
      this.$store.commit("article/showEditUnitDialog", {
        unit: unit,
      });
    },
    // ========
    CreateCategory() {
      this.$store.commit("article/showCreateUnitDialog");
    },
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
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>