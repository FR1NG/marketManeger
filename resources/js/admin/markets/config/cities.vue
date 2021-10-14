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
              <v-list-item-content>
                <v-list-item-title v-text="item.name"></v-list-item-title>
                <v-list-item-subtitle
                  v-text="`Nombre de branchements : ${item.branchements_count}`"
                ></v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-btn icon :loading="item.removeLoading" @click="remove(item)">
                  <v-icon color="red"> mdi-close-circle-outline </v-icon>
                </v-btn>
              </v-list-item-action>
            </v-list-item>
          </template>
        </v-list>
      </v-col>
      <v-spacer></v-spacer>
    </v-row>
  </v-card>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
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
    ...mapMutations({
      setRemoveCityLoading: "admin/marketsConfig/setRemoveCityLoading",
      endRemoveCityLoading: "admin/marketsConfig/endRemoveCityLoading",
    }),
    ...mapActions({
      store: "admin/marketsConfig/storeCity",
      getData: "admin/marketsConfig/getCities",
      deleteCity: "admin/marketsConfig/deleteCity",
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
    remove(item) {
      if (!item.removeLoading) {
        this.setRemoveCityLoading({ id: item.id });
        this.deleteCity({ id: item.id, market_id: this.$route.params.id });
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