<template>
  <div>
    <v-card
      class="d-flex align-center justify-center mb-6"
      flat
      height="90vh"
      tile
    >
      <v-card class="pa-2 d-flex justify-center" flat>
        <h2 class="d-inline-block">Page introuvable</h2>
        <v-btn link :to="{ name: 'dashboard' }" icon large color="primary">
          <v-icon color="primary"> mdi-home-outline </v-icon>
        </v-btn>
      </v-card>
    </v-card>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>