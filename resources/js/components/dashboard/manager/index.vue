
<template>
  <div>
    <v-row>
      <statistics></statistics>
      <v-col cols="12" class="d-flex justify-center">
        <v-select
          v-model="branchementType"
          :items="articles"
          item-text="display_name"
          item-value="id"
          outlined
          label="Type de branchement"
        ></v-select>
      </v-col>
      <week-progress></week-progress>
      <markets-accomplishment></markets-accomplishment>
      <cities-statistics></cities-statistics>
    </v-row>
  </div>
</template>

<script>
import WeekProgress from "./partials/WeekProgress.vue";
import MarketsAccomplishment from "./partials/MarketsAccomplishment.vue";
import Statistics from "./partials/statistics.vue";
import CitiesStatistics from "./partials/CitiesStatistics.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    WeekProgress,
    Statistics,
    MarketsAccomplishment,
    CitiesStatistics,
  },

  watch: {
    branchementType: {
      handler() {
        this.getData();
      },
      deep: true,
    },
  },
  computed: {
    ...mapGetters({
      articles: "dashboard/articles",
    }),
    branchementType: {
      get() {
        this.$store.getters["dashboard/branchementType"];
      },
      set(val) {
        this.$store.commit("dashboard/setBranchementType", val);
      },
    },
  },
  methods: {
    getData() {
      this.$store.dispatch("dashboard/getData");
    },
  },
  beforeRouteUpdate(to, from, next) {
    alert("alerttt");
    // called when the route that renders this component is about to
    // be navigated away from.
    // has access to `this` component instance.
  },
  created() {},
};
</script>

<style>
</style>