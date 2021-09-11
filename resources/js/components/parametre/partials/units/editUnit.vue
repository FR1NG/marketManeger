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
              <v-col cols="12">
                <v-text-field
                  label="Abréviation*"
                  required
                  v-model="abr"
                  :error-messages="errors.abr[0]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  label="Description"
                  required
                  v-model="description"
                  :error-messages="errors.description[0]"
                ></v-textarea>
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
      name: "",
      abr: "",
      description: "",
      errors: {
        name: [],
        abr: [],
        description: [],
      },
      loading: false,
    };
  },
  computed: {
    unit() {
      return this.$store.getters["article/unitToEdit"];
    },
  },
  methods: {
    closeDialog() {
      this.$store.commit("article/hideEditUnitDialog");
    },
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("article/updateUnit", {
          id: this.id,
          name: this.name,
          abr: this.abr,
          description: this.description,
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
            error.data.errors.abr
              ? (this.errors.abr = error.data.errors.abr)
              : (this.errors.abr = []);
            error.data.errors.description
              ? (this.errors.description = error.data.errors.description)
              : (this.errors.description = []);
          }
          // stop loading
          this.loading = false;
        });
    },
  },
  created() {
    this.name = this.unit.name;
    this.abr = this.unit.abr;
    this.description = this.unit.description;
    this.id = this.unit.id;
  },
};
</script>

<style>
</style>