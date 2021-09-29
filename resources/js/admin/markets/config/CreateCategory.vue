<template>
  <!-- create category:BEGIN -->
  <v-dialog
    :value="true"
    persistent
    max-width="500px"
    transition="dialog-transition"
  >
    <v-card class="pa-4">
      <v-card-title>Créer catégorie </v-card-title>
      <v-form @submit.prevent="handleSubmit">
        <v-text-field
          label="Nom"
          v-model="name"
          :error-messages="errors.name"
        ></v-text-field>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="hideCreateCategoryDialog">Annuler</v-btn>
          <v-btn color="primary" type="submit" :loading="loading"
            >Enregistrer</v-btn
          >
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
  <!-- create category:END -->
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
  data() {
    return {
      name: "",
      errors: {
        name: [],
      },
      loading: false,
    };
  },
  methods: {
    ...mapMutations({
      hideCreateCategoryDialog: "admin/marketsConfig/hideCreateCategoryDialog",
    }),
    ...mapActions({
      store: "admin/marketsConfig/storeCategory",
    }),
    handleSubmit() {
      this.loading = true;
      this.store({ name: this.name, market_id: this.$route.params.id })
        .then(() => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          //   push errors
          error.response.data.errors.name
            ? (this.errors.name = error.response.data.errors.name)
            : null;
        });
    },
  },
};
</script>

<style>
</style>