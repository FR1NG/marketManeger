<template>
  <v-dialog :value="true" persistent max-width="400px">
    <v-card :loading="loading" :disabled="loading">
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
                  v-model="form.name"
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
                  v-model="form.category"
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
                  v-model="form.unit"
                  :error-messages="errors.unit[0]"
                ></v-select>
                <v-text-field
                  label="Quantité de notification"
                  required
                  v-model="form.notificationQuantity"
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
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      form: {
        id: null,
        name: "",
        category: null,
        unit: null,
        notificationQuantity: null,
      },
      errors: {
        name: [],
        category: [],
        unit: [],
        notificationQuantity: [],
      },
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      article: "article/articleToEdit",
      units: "article/units",
      categories: "article/categories",
    }),
  },
  methods: {
    closeDialog() {
      this.$store.commit("article/hideEditArticleDialog");
    },
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("article/updateArticle", {
          form: this.form,
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
            error.data.errors.category
              ? (this.errors.category = error.data.errors.category)
              : (this.errors.category = []);
            error.data.errors.unit
              ? (this.errors.unit = error.data.errors.unit)
              : (this.errors.unit = []);
            error.data.errors.notificationQuantity
              ? (this.errors.notificationQuantity =
                  error.data.errors.notificationQuantity)
              : (this.errors.notificationQuantity = []);
          }
          // stop loading
          this.loading = false;
        });
    },
    setData() {
      this.form.id = this.article.id;
      this.form.name = this.article.name;
      this.form.category = this.article.category_id;
      this.form.unit = this.article.unit_id;
      this.form.notificationQuantity = this.article.notification_quantity;
    },
  },
  created() {
    this.setData();
  },
};
</script>

<style>
</style>