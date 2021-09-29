<template>
  <v-card :loading="loading" flat>
    <v-row class="mx-auto">
      <v-spacer></v-spacer>
      <v-col cols="12" md="6">
        <v-form @submit.prevent="handleSubmit">
          <v-text-field
            label="Ville"
            v-model="name"
            :error-messages="errors.name"
          ></v-text-field>
          <v-btn color="success" type="submit" :loading="submitLoading"
            >Ajouter</v-btn
          >
        </v-form>
        <v-list>
          <template v-for="item in cities">
            <v-divider :key="item.id + 0.5"></v-divider>
            <v-list-item :key="item.id">
              <v-divider></v-divider>
              <v-list-item-title v-text="item.name"></v-list-item-title>
              <v-list-item-action
                v-text="item.branchements_count"
              ></v-list-item-action>
            </v-list-item>
          </template>
        </v-list>
      </v-col>
      <v-spacer></v-spacer>
    </v-row>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      loading: false,
      submitLoading: false,
      name: "",
      errors: {
        name: [],
      },
    };
  },
  computed: {
    ...mapGetters({
      cities: "admin/marketsConfig/cities",
    }),
  },
  methods: {
    ...mapActions({
      store: "admin/marketsConfig/storeCity",
      getData: "admin/marketsConfig/getCities",
    }),
    handleSubmit() {
      if (!this.submitLoading) {
        this.errors.name = [];
        this.submitLoading = true;
        this.store({ name: this.name, market_id: this.$route.params.id })
          .then(() => {
            this.submitLoading = false;
            this.getData({ market_id: this.$route.params.id });
            this.name = "";
          })
          .catch((error) => {
            this.submitLoading = false;
            error.response.data.errors.name
              ? (this.errors.name = error.response.data.errors.name)
              : null;
          });
      }
    },
  },
  created() {
    this.getData({ market_id: this.$route.params.id });
  },
};
</script>

<style>
</style>