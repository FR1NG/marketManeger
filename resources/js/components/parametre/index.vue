<template>
  <v-container>
    <v-card>
      <v-toolbar color="red darken-1" dark flat>
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
      </v-tabs-items>
    </v-card>
  </v-container>
</template>

<script>
import Article from "./partials/articles/articles.vue";
export default {
  components: {
    Article,
  },
  data() {
    return {
      tab: null,
      items: ["afichage", "articles", "Catégories", "Unités de mesure"],
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    };
  },
};
</script>
<style>
</style>