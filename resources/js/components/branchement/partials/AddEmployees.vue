<template>
  <v-dialog
    :value="true"
    scrollable
    persistent
    max-width="500px"
    transition="dialog-transition"
  >
    <v-card :loading="submitLoading" :disabled="submitLoading">
      <v-card-title> Sélectionner des employés</v-card-title>
      <v-form @submit.prevent="handleSubmit">
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-autocomplete
                :items="items"
                item-text="name"
                item-value="id"
                v-model="selectedEmployee"
                chips
                label="Employés"
                outlined
                :loading="loading"
              ></v-autocomplete>
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
    };
  },
  computed: {
    items() {
      return this.$store.getters["branchement/employees"];
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store.dispatch("branchement/getEmployees").then(() => {
        this.loading = false;
      });
    },
    handleSubmit() {
      if (!this.submitLoading) {
        this.submitLoading = true;
        this.$store
          .dispatch("branchement/addEmployees", {
            employe_id: this.selectedEmployee,
            branchement_id: this.$route.params.id,
          })
          .then(() => {
            this.submitLoading = false;
          })
          .catch((error) => {
            this.submitLoading = false;
          });
      }
    },
    hideDialog() {
      this.$store.commit("branchement/hideAddEmployees");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>