<template>
  <v-expand-transition>
    <v-snackbar v-if="alert">
      <v-alert class="ma-4" :type="type">
        {{ text }}
      </v-alert>
    </v-snackbar>
  </v-expand-transition>
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
    alert() {
      return this.$store.getters["alert/alert"];
    },
  },
  mounted() {
    //scroll to the top
    this.$vuetify.goTo(0, {
      duration: 200,
      offset: 0,
      easing: "easeOutQuad",
    });
  },
};
</script>