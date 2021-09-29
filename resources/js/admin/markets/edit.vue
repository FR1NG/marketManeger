<template>
  <v-container>
    <v-subheader>
      <v-btn icon link :to="{ name: 'adminMarkets' }">
        <v-icon> mdi-format-list-bulleted-square </v-icon>
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn icon link :href="'/market/' + $route.params.id">
        <v-icon>mdi-account-arrow-right-outline</v-icon>
      </v-btn>
    </v-subheader>
    <v-card min-height="600">
      <v-card-text>
        <v-tabs background-color="primary" centered dark icons-and-text>
          <v-tabs-slider></v-tabs-slider>

          <v-tab link :to="{ name: 'adminMarketInfo' }">
            Info
            <v-icon>mdi-information-outline</v-icon>
          </v-tab>

          <v-tab link :to="{ name: 'adminMarketArticles' }">
            Articles
            <v-icon>mdi-file-tree</v-icon>
          </v-tab>
          <v-tab link :to="{ name: 'adminMarketCities' }">
            Villes
            <v-icon>mdi-home-city-outline</v-icon>
          </v-tab>

          <v-tab link :to="{ name: 'adminMarketStatistics' }">
            Statistiques
            <v-icon>mdi-chart-line</v-icon>
          </v-tab>
        </v-tabs>

        <v-tabs-items>
          <v-card flat>
            <v-card-text>
              <router-view></router-view>
            </v-card-text>
          </v-card>
        </v-tabs-items>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {};
</script>

<style>
</style>