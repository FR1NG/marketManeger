<template>
  <v-dialog :value="true" persistent max-width="400">
    <v-card>
      <v-card-title class="text-h5">
        êtes-vous sûr de vouloir supprimer cette Catégorie?
      </v-card-title>
      <v-card-text></v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="endDelete"> Annuler </v-btn>
        <v-btn color="error" @click="confirmDelete" :loading="loading">
          Suprimer
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
    };
  },
  computed: {
    deleteDialog() {
      return this.$store.getters["employe/deleteDialog"];
    },
  },
  methods: {
    endDelete() {
      this.$store.commit("admin/marketsConfig/endCategoryDelete");
    },
    confirmDelete() {
      this.loading = true;
      this.$store
        .dispatch("admin/marketsConfig/deleteCategory", {
          market_id: this.$route.params.id,
        })
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
  },
};
</script>

<style>
</style>