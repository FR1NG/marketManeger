<template>
  <v-dialog :value="true" persistent max-width="400">
    <v-card :disabled="loading" :loading="loading">
      <v-card-title class="text-h5">
        êtes-vous sûr de vouloir supprimer le marché № {{ toDelete.number }}?
      </v-card-title>
      <v-card-text>
        toutes les données liées à ce marché seront supprimées
        <v-text-field
          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
          :type="show ? 'text' : 'password'"
          label="Mot de pass"
          v-model="pass"
          name="pass"
          :autocomplete="false"
          class="input-group--focused"
          @click:append="show = !show"
        ></v-text-field>
      </v-card-text>
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
      pass: null,
      show: false,
    };
  },
  computed: {
    toDelete() {
      return this.$store.getters["admin/markets/toDelete"];
    },
  },
  methods: {
    endDelete() {
      this.$store.commit("admin/markets/endDelete");
    },
    confirmDelete() {
      if (!this.loading) {
        this.loading = true;
        this.$store
          .dispatch("admin/markets/delete", { password: this.pass })
          .then(() => {
            this.loading = false;
            this.endDelete();
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