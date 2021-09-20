<template>
  <v-dialog
    :value="true"
    scrollable
    persistent
    max-width="500px"
    transition="dialog-transition"
  >
    <v-card>
      <v-card-title> Sélectionner des pièces </v-card-title>
      <v-form @submit.prevent="handleSubmit">
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-select
                :items="items"
                item-text="name"
                item-value="id"
                v-model="selectedItems"
                chips
                label="Pièces"
                multiple
                outlined
                :loading="loading"
              ></v-select>
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
      selectedItems: [],
    };
  },
  computed: {
    items() {
      return this.$store.getters["branchement/articles"];
    },
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store.dispatch("branchement/getArticles").then(() => {
        this.loading = false;
      });
    },
    handleSubmit() {
      this.submitLoading = true;
      this.$store
        .dispatch("branchement/addArticles", {
          items: this.selectedItems,
          branchement_id: this.$route.params.id,
        })
        .then(() => {
          this.submitLoading = false;
        })
        .catch((error) => {
          this.submitLoading = false;
        });
    },
    hideDialog() {
      this.$store.commit("branchement/hideAddArticles");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>