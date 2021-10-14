<template>
  <v-card flat :loading="loading" :disabled="loading">
    <v-toolbar flat>
      <v-toolbar-title> Filtré les branchements </v-toolbar-title>
      <v-divider inset vertical class="mx-4"></v-divider>
    </v-toolbar>
    <v-card-text>
      <v-row>
        <v-col cols="12" md="3">
          <v-select
            label="Branchements"
            :items="branchements"
            item-text="display_name"
            v-model="filter.branchement"
            item-value="id"
          ></v-select>
        </v-col>
        <v-col cols="12" md="3">
          <v-select
            label="Type"
            :items="['normal', 'social']"
            v-model="filter.type"
          ></v-select>
        </v-col>
        <v-col cols="12" md="3">
          <v-select
            label="Ville"
            :items="cities"
            item-text="name"
            item-value="id"
            v-model="filter.city"
          ></v-select>
        </v-col>
        <v-col cols="12" md="3">
          <v-dialog
            ref="dialog"
            v-model="modal"
            :return-value.sync="filter.range"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="filter.range"
                label="Date entre"
                apppend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="filter.range" scrollable range>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="modal = false">
                Cancel
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="$refs.dialog.save(filter.range)"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-dialog>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn text @click="hideFilter">Annuler</v-btn>
      <v-btn @click="handleFilter" color="info" :loading="getLoading"
        >filtré</v-btn
      >
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: ["getLoading"],
  data() {
    return {
      modal: false,
      loading: false,
      branchements: [],
      cities: [],

      filter: {
        branchement: null,
        type: null,
        city: null,
        range: null,
      },
    };
  },
  methods: {
    handleFilter() {
      this.$store.commit("branchement/setFilter", { filter: this.filter });
    },
    getData() {
      this.loading = true;
      this.$store.dispatch("branchement/getFilterData").then((response) => {
        console.log(response.data.cities);
        this.loading = false;
        this.cities = response.data.cities;
        this.branchements = response.data.branchements;
      });
    },
    hideFilter() {
      this.$store.commit("branchement/hideFilter");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>