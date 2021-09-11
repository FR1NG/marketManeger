<template>
  <v-dialog :value="true" persistent max-width="400px">
    <v-card>
      <v-form @submit.prevent="handleSubmit">
        <v-card-title>
          <span class="text-h5">Modifier Catégorie</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Nom de Catégorie*"
                  required
                  v-model="name"
                  :error-messages="errors.name[0]"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="closeDialog"> Annuler </v-btn>
          <v-btn color="primary" type="submit" outlined :loading="loading">
            Enregistrer
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      id: null,
      name: "",
      errors: {
        name: [],
      },
      loading: false,
    };
  },
  computed: {
    category() {
      return this.$store.getters["article/categoryToEdit"];
    },
  },
  methods: {
    closeDialog() {
      this.$store.commit("article/hideEditCategoryDialog");
    },
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("article/updateCategory", {
          id: this.id,
          name: this.name,
        })
        .then(() => {
          // stop loading
          this.loading = false;
          // hide dialog
          this.closeDialog();
        })
        .catch((error) => {
          // push errors
          if (error) {
            error.data.errors.name
              ? (this.errors.name = error.data.errors.name)
              : (this.errors.name = []);
          }
          // stop loading
          this.loading = false;
        });
    },
  },
  created() {
    this.name = this.category.name;
    this.id = this.category.id;
  },
};
</script>

<style>
</style>