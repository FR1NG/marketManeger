<template>
  <v-snackbar :timeout="-1" :value="true" top :color="type">
    <v-list-item>
      <v-list-item-icon>
        <v-icon v-text="icon"></v-icon>
      </v-list-item-icon>
      <v-list-item-content v-text="text"> </v-list-item-content>
    </v-list-item>
  </v-snackbar>
</template>

<script>
export default {
  computed: {
    type() {
      return this.$store.getters["alert/type"];
    },
    text() {
      return this.$store.getters["alert/text"];
    },

    icon() {
      let icon;
      let color;
      switch (this.type) {
        case "error":
          icon = "mdi-alert-outline";
          break;
        case "success":
          icon = "mdi-check-outline";
          break;
        case "info":
          icon = "mdi-alert-circle-outline";
          break;
        default:
          icon = "mdi-bell-outline";
          break;
      }
      return icon;
    },
  },
};
</script>

<style>
</style>