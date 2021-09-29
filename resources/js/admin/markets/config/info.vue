<template>
  <v-form ref="form" @submit.prevent="handleSubmit">
    <v-card flat :loading="getLoading" pt-4>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.manager.name"
            label="Nom de gérant"
            :error-messages="errors.manager.name"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.manager.email"
            :error-messages="errors.manager.email"
            type="email"
            label="Email de gérant"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.name"
            :error-messages="errors.name"
            label="Nom de marché"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.market_number"
            :error-messages="errors.market_number"
            label="№ de marché"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.amount"
            :error-messages="errors.amoun"
            label="Montant"
          ></v-text-field>
        </v-col>
        <!-- service_order_date : BEGIN -->
        <v-col cols="12" md="6">
          <v-dialog
            ref="service_order_date"
            v-model="date1"
            :return-value.sync="form.service_order_date"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.service_order_date"
                :error-messages="errors.service_order_date"
                label="Date d'ordre service"
                append-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.service_order_date" scrollable>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="date1 = false">
                Annuler
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="$refs.service_order_date.save(form.service_order_date)"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-dialog>
        </v-col>
        <!-- service_order_date : END -->

        <!-- service_order_date : BEGIN -->
        <v-col cols="12" md="6">
          <v-dialog
            ref="deadline_date"
            v-model="date2"
            :return-value.sync="form.deadline_date"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.deadline_date"
                :error-messages="errors.deadline_date"
                label="Date délai"
                append-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.deadline_date" scrollable>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="date2 = false">
                Annuler
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="$refs.deadline_date.save(form.deadline_date)"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-dialog>
        </v-col>
        <!-- deadline_date : END -->
      </v-row>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="success" class="mr-4" type="submit" :loading="loading"
          >mettre à jour
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      form: {
        name: "",
        market_number: "",
        service_order_date: null,
        deadline_date: null,
        manager: {
          name: "",
          email: "",
        },
      },
      errors: {
        name: [],
        market_number: [],
        service_order_date: [],
        deadline_date: [],
        manager: {
          name: [],
          email: [],
        },
      },
      loading: false,
      getLoading: false,
      date1: false,
      date2: false,
    };
  },
  computed: {
    ...mapGetters({
      info: "admin/marketsConfig/info",
    }),
  },
  methods: {
    ...mapActions({
      getData: "admin/marketsConfig/getInfo",
    }),
    handleSubmit() {
      if (!this.loading) {
        this.loading = true;
        this.$store
          .dispatch("admin/markets/store", { form: this.form })
          .then((response) => {
            this.loading = false;
            this.resetForm();
            this.$router.replace({
              name: "adminMarketsEdit",
              params: {
                id: response.data.market_id,
              },
            });
          })
          .catch((error) => {
            this.loading = false;
            if (error.response.data.errors) {
              const errors = error.response.data.errors;
              errors.name ? (this.errors.name = errors.name) : null;
              errors.market_number
                ? (this.errors.market_number = errors.market_number)
                : null;
              errors.service_order_date
                ? (this.errors.service_order_date = errors.service_order_date)
                : null;
              errors.deadline_date
                ? (this.errors.deadline_date = errors.deadline_date)
                : null;
              errors["user.name"]
                ? (this.errors.user.name = errors["user.name"])
                : null;
              errors["user.email"]
                ? (this.errors.user.email = errors["user.email"])
                : [];
            }
          });
      }
    },
  },
  created() {
    this.getLoading = true;
    this.getData({ id: this.$route.params.id }).then(() => {
      this.form = this.info;
      this.getLoading = false;
    });
  },
};
</script>

<style>
</style>