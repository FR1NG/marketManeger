<template>
  <v-card class="ma-4">
    <v-data-table :headers="headers" :search="search">
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>List Des Fournisseur</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            link
            color="primary"
            dark
            class="mb-2"
            :to="{ name: 'ajouterFournisseur' }"
          >
            Ajouter
          </v-btn>
        </v-toolbar>

        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        { text: "Nom", value: "Nom" },
        { text: "Address", value: "Address" },
        { text: "Tele", value: "Tele" },
        { text: "Nbr d'operation", value: "nbrdop" },
      ],
      search: "test",
    };
  },
};
</script>

<style>
</style>