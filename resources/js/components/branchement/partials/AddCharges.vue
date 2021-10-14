<template>
  <v-dialog
    :value="true"
    scrollable
    persistent
    max-width="500px"
    transition="dialog-transition"
  >
    <v-card :loading="submitLoading" :disabled="submitLoading">
      <v-card-title> Ajouter les Charges</v-card-title>
      <v-form @submit.prevent="handleSubmit">
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-text-field
                label="Nature de charge"
                v-model="form.nature"
                :error-messages="errors.nature"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Montant"
                type="number"
                v-model="form.amount"
                :error-messages="errors.amount"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text color="secondary" @click="hideDialog">Annuler</v-btn>
          <v-btn color="primary" type="submit" :loading="submitLoading"
            >Enregister</v-btn
          >
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      submitLoading: false,
      selectedEmployee: null,
      form: {
        nature: "",
        amount: null,
      },
      errors: {
        nature: [],
        amount: [],
      },
    };
  },
  computed: {},
  methods: {
    handleSubmit() {
      if (!this.submitLoading) {
        this.resetErrors();
        this.submitLoading = true;
        this.$store
          .dispatch("branchement/addCharges", {
            form: this.form,
            branchement_id: this.$route.params.id,
          })
          .then(() => {
            //   stop loading
            this.submitLoading = false;
            // hide dialog
            this.hideDialog();
          })
          .catch((error) => {
            this.submitLoading = false;
            if (error.response.data.errors) {
              const errors = error.response.data.errors;
              errors.nature ? (this.errors.nature = errors.nature) : null;
              errors.amount ? (this.errors.amount = errors.amount) : null;
            }
          });
      }
    },
    hideDialog() {
      this.$store.commit("branchement/hideAddCharges");
    },
    resetErrors() {
      this.errors = {
        nature: [],
        amount: [],
      };
    },
  },
};
</script>

<style>
</style>