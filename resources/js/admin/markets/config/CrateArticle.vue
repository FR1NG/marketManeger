<template>
  <!-- create category:BEGIN -->
  <v-dialog
    :value="true"
    persistent
    max-width="500px"
    transition="dialog-transition"
  >
    <v-card class="pa-4">
      <v-card-title>Créer type de branchement </v-card-title>
      <v-form @submit.prevent="handleSubmit">
        <v-text-field
          label="Nom"
          v-model="form.name"
          :error-messages="errors.name"
        ></v-text-field>

        <v-text-field
          label="Nom d'affichage"
          v-model="form.display_name"
          :error-messages="errors.display_name"
        ></v-text-field>

        <v-text-field
          label="Unité"
          v-model="form.unit"
          :error-messages="errors.unit"
        ></v-text-field>

        <v-text-field
          label="Quantité"
          type="number"
          v-model="form.quantity"
          :error-messages="errors.quantity"
        ></v-text-field>

        <v-text-field
          label="Prix unitaire"
          type="number"
          v-model="form.unit_price"
          :error-messages="errors.unit_price"
        ></v-text-field>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="hideCreateArticleDialog">Annuler</v-btn>
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
      form: {
        name: "",
        display_name: "",
        unit: "",
        quantity: null,
        unit_price: null,
      },
      errors: {
        name: [],
        display_name: [],
        unit: [],
        quantity: [],
        unit_price: [],
      },
      loading: false,
    };
  },
  methods: {
    ...mapMutations({
      hideCreateArticleDialog: "admin/marketsConfig/hideCreateArticleDialog",
    }),
    ...mapActions({
      store: "admin/marketsConfig/storeArticle",
    }),
    handleSubmit() {
      if (this.loading === false) {
        this.loading = true;
        this.store({ form: this.form, market_id: this.$route.params.id })
          .then(() => {
            //   stop loading
            this.loading = false;
            // reset form
            this.resetForm();
            // hide dialog
            this.hideCreateArticleDialog();
          })
          .catch((error) => {
            this.loading = false;
            //   push errors
            if (error.response.data.errors) {
              const errors = error.response.data.errors;
              errors.name ? (this.errors.name = errors.name) : null;
              errors.display_name
                ? (this.errors.display_name = errors.display_name)
                : null;
              errors.quantity ? (this.errors.quantity = errors.quantity) : null;
              errors.unit ? (this.errors.unit = errors.unit) : null;
              errors.unit_price
                ? (this.errors.unit_price = errors.unit_price)
                : null;
            }
          });
      }
    },
    resetForm() {
      this.form = {
        name: "",
        display_name: "",
        unit: "",
        quantity: null,
        unit_price: null,
      };
      this.errors = {
        name: [],
        display_name: [],
        unit: [],
        quantity: [],
        unit_price: [],
      };
    },
  },
};
</script>

<style>
</style>