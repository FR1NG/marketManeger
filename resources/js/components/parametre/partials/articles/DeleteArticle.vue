<template>
  <v-dialog :value="true" persistent max-width="400">
    <v-card :disabled="loading" :loading="loading">
      <v-card-title class="text-h5">
        êtes-vous sûr de vouloir supprimer ce article?
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
  methods: {
    endDelete() {
      this.$store.commit("article/endDeleteArticle");
    },
    confirmDelete() {
      if (!this.loading) {
        this.loading = true;
        this.$store
          .dispatch("article/deleteArticle")
          .then(() => {
            this.loading = false;
          })
          .catch(() => {
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style>
</style>