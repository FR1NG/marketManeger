<template>
  <v-container>
    <v-card>
      <v-toolbar color="primary" dark flat>
        <template v-slot:extension>
          <v-tabs v-model="tab" align-with-title>
            <v-tabs-slider color="yellow"></v-tabs-slider>

            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>
      </v-toolbar>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat v-if="tab == 0">
            <v-card-text>afichage component</v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat v-if="tab == 1">
            <Article></Article>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat v-if="tab == 2">
            <categories></categories>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat v-if="tab == 3">
            <units></units>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-container>
</template>

<script>
import Article from "./partials/articles/articles.vue";
import Categories from "./partials/categories/categories.vue";
import Units from "./partials/units/units.vue";
export default {
  components: {
    Article,
    Categories,
    Units,
  },
  data() {
    return {
      tab: null,
      items: ["afichage", "articles", "Catégories", "Unités de mesure"],
    };
  },
};
</script>
<style>
</style>