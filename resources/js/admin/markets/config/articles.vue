<template>
  <v-card flat :loading="loading" class="pa-4">
    <!-- create Category :BEGIN -->
    <create-category v-if="createCategoryDialog"></create-category>
    <!-- create Category :END -->
    <!-- create article :BEGIN -->
    <crate-article v-if="createArticleDialog"></crate-article>
    <!-- create article :END -->
    <v-toolbar flat>
      <v-toolbar-title> List des Branchement </v-toolbar-title>
      <v-divider inset vertical class="mx-4"></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="info" @click="showCreateCategoryDialog"
        >Ajouter une Categorie</v-btn
      >
    </v-toolbar>
    <v-row>
      <v-col cols="12" v-for="item in items" :key="item.id">
        <div>
          <v-toolbar prominent dark color="deep-purple darken-4">
            <v-app-bar-nav-icon
              @click="showCreateArticleDialog({ id: item.id })"
            >
              <v-icon>mdi-playlist-plus</v-icon>
            </v-app-bar-nav-icon>

            <v-toolbar-title v-text="item.name"></v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
              <v-icon>mdi-trash-can-outline</v-icon>
            </v-btn>
          </v-toolbar>
        </div>
        <v-row>
          <v-col
            cols="12"
            md="3"
            v-for="article in item.articles"
            :key="article.id"
          >
            <v-card class="mx-auto my-12" max-width="374">
              <template slot="progress">
                <v-progress-linear
                  color="deep-purple"
                  height="10"
                  indeterminate
                ></v-progress-linear>
              </template>

              <v-card-title v-text="article.display_name"></v-card-title>

              <v-card-text>
                <div class="my-4">
                  <span class="font-weight-bold">Unité :</span> :
                  {{ article.unit }}
                </div>
                <div class="my-4">
                  <span class="font-weight-bold">Quantité :</span> :
                  {{ article.quantity }}
                </div>
                <div class="my-4">
                  <span class="font-weight-bold">Prix unitaire :</span> :
                  {{ locString(article.unit_price) }}
                </div>
                <div class="my-4">
                  <span class="font-weight-bold">Montant :</span> :
                  {{ locString(article.unit_price * article.quantity) }}
                </div>
                <div class="my-4">
                  <v-progress-linear
                    :value="
                      (article.branchements_count / article.quantity) * 100
                    "
                  ></v-progress-linear>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
import CreateCategory from "./CreateCategory.vue";
import { mapGetters, mapMutations, mapActions } from "vuex";
import CrateArticle from "./CrateArticle.vue";
export default {
  components: { CreateCategory, CrateArticle },
  data() {
    return {};
  },
  computed: {
    ...mapGetters({
      createCategoryDialog: "admin/marketsConfig/createCategoryDialog",
      createArticleDialog: "admin/marketsConfig/createArticleDialog",
      items: "admin/marketsConfig/articles",
      loading: "admin/marketsConfig/loading",
    }),
  },
  methods: {
    ...mapMutations({
      showCreateCategoryDialog: "admin/marketsConfig/showCreateCategoryDialog",
      showCreateArticleDialog: "admin/marketsConfig/showCreateArticleDialog",
    }),
    ...mapActions({
      getData: "admin/marketsConfig/gatArticles",
    }),
    locString(num) {
      return num.toLocaleString();
    },
  },

  created() {
    this.getData({ market_id: this.$route.params.id });
  },
};
</script>

<style>
</style>