<template>
  <v-card rounded class="mt-4">
    <v-container>
      <v-row>
        <v-col cols="12">
          <line-chart></line-chart>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
import LineChart from "../../extra/LineChart.vue";
export default {
  components: { LineChart },
};
</script>

<style>
</style>