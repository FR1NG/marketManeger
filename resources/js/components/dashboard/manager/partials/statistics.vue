<template>
  <v-col cols="12">
    <v-row class="mt-4">
      <!-- BEGIN:to day  -->
      <v-col cols="12" md="4">
        <v-card rounded min-height="140">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="overline mb-4">Branchement de ce mois</div>
              <v-list-item-title
                class="headline mb-1"
                v-text="statistics.branchements_count"
              >
                0</v-list-item-title
              >
            </v-list-item-content>
            <v-list-item-avatar tile size="80" class="number-icon">
              <v-icon size="80" color="primary lighten-4">mdi-tools</v-icon>
            </v-list-item-avatar>
          </v-list-item>
        </v-card>
      </v-col>

      <!-- END:to day  -->

      <!-- BEGIN: -->
      <v-col cols="12" md="4">
        <v-card rounded min-height="140">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="overline mb-4">Chifre d'affaire de ce mois</div>
              <v-list-item-title
                class="headline mb-1"
                v-text="statistics.incom"
              >
                0.00</v-list-item-title
              >
            </v-list-item-content>
            <v-list-item-avatar tile size="80" class="number-icon">
              <v-icon size="80" color="primary lighten-4"
                >mdi-cash-multiple</v-icon
              >
            </v-list-item-avatar>
          </v-list-item>
        </v-card>
      </v-col>

      <!-- END: -->

      <!-- BEGIN:today -->
      <v-col cols="12" md="4">
        <v-card
          rounded
          min-height="140"
          class="cursor-pointer"
          link
          :to="{ name: 'depot' }"
        >
          <v-list-item three-line>
            <v-list-item-content>
              <div class="overline mb-4">Rupture de stock</div>
              <v-list-item-title
                class="headline mb-1 red--text"
                v-text="statistics.shortage_count"
              >
                0</v-list-item-title
              >
            </v-list-item-content>
            <v-list-item-avatar tile size="80" class="number-icon">
              <v-icon size="80" color="primary lighten-4"
                >mdi-alert-outline</v-icon
              >
            </v-list-item-avatar>
          </v-list-item>
        </v-card>
      </v-col>

      <!-- END:today -->
    </v-row>
  </v-col>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      statistics: "dashboard/statistics",
    }),
  },
};
</script>

<style lang="scss" scopped>
.number-icon {
  transition: all 0.5s ease;
}
.number-icon:hover {
  transform: scale3d(1.3, 1.3, 1.3);
}
</style>