<template>
  <v-dialog :value="true" persistent max-width="400px">
    <v-card>
      <v-form @submit.prevent="handleSubmit">
        <v-card-title>
          <span class="text-h5">Nouveau Article</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="désignation*"
                  required
                  v-model="name"
                  :error-messages="errors.name[0]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Catégorie*"
                  required
                  :items="categories"
                  item-text="name"
                  item-value="id"
                  v-model="category"
                  :error-messages="errors.category[0]"
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Unité de mesure*"
                  required
                  :items="units"
                  item-text="name"
                  item-value="id"
                  v-model="unit"
                  :error-messages="errors.unit[0]"
                ></v-select>
                <v-text-field
                  label="Quantité de notification"
                  required
                  v-model="notificationQuantity"
                  type="number"
                  :error-messages="errors.notificationQuantity[0]"
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
      name: "",
      category: null,
      unit: null,
      notificationQuantity: null,
      errors: {
        name: [],
        category: [],
        unit: [],
        notificationQuantity: [],
      },
      loading: false,
      selectLoading: false,
    };
  },
  computed: {
    categories() {
      return this.$store.getters["article/categories"];
    },
    units() {
      return this.$store.getters["article/units"];
    },
  },
  methods: {
    closeDialog() {
      this.$store.commit("article/hideCreateArticleDialog");
    },
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("article/storeArticle", {
          name: this.name,
          category: this.category,
          unit: this.unit,
          notificationQuantity: this.notificationQuantity,
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
};
</script>

<style>
</style>