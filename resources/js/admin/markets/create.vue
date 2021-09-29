<template>
  <v-card class="ma-4 pa-4">
    <v-toolbar flat>
      <v-toolbar-title>Nouveau marché</v-toolbar-title>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-btn
        link
        color="primary"
        dark
        class="mb-2"
        :to="{ name: 'adminMarkets' }"
      >
        Retour à la list
      </v-btn>
    </v-toolbar>

    <v-form ref="form" @submit.prevent="handleSubmit">
      <v-text-field
        v-model="form.user.name"
        label="Nom de gérant"
        :error-messages="errors.user.name"
      ></v-text-field>
      <v-text-field
        v-model="form.user.email"
        :error-messages="errors.user.email"
        type="email"
        label="Email de gérant"
      ></v-text-field>
      <v-text-field
        v-model="form.name"
        :error-messages="errors.name"
        label="Nom de marché"
      ></v-text-field>
      <v-text-field
        v-model="form.market_number"
        :error-messages="errors.market_number"
        label="№ de marché"
      ></v-text-field>

      <v-text-field
        label="Montant"
        type="number"
        v-model="form.amount"
        :error-messages="errors.amount"
      ></v-text-field>
      <!-- service_order_date : BEGIN -->
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
          <v-btn text color="primary" @click="date1 = false"> Annuler </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.service_order_date.save(form.service_order_date)"
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-dialog>
      <!-- service_order_date : END -->

      <!-- service_order_date : BEGIN -->
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
          <v-btn text color="primary" @click="date2 = false"> Annuler </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.deadline_date.save(form.deadline_date)"
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-dialog>
      <!-- deadline_date : END -->

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined class="mr-4" @click="resetForm">Annuler</v-btn>
        <v-btn color="success" class="mr-4" type="submit" :loading="loading"
          >Ajouter
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      form: {
        name: "",
        market_number: "",
        amount: null,
        service_order_date: null,
        deadline_date: null,
        user: {
          name: "",
          email: "",
        },
      },
      errors: {
        name: [],
        market_number: [],
        amount: [],
        service_order_date: [],
        deadline_date: [],
        user: {
          name: [],
          email: [],
        },
      },
      loading: false,
      date1: false,
      date2: false,
    };
  },
  computed: {
    ...mapGetters({}),
  },
  methods: {
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
              errors.amount ? (this.errors.amoun = errors.amount) : null;
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
    resetForm() {
      this.form = {
        name: "",
        market_number: "",
        service_order_date: null,
        deadline_date: null,
        user: {
          name: "",
          email: "",
        },
      };
      this.errors = {
        name: [],
        market_number: [],
        service_order_date: [],
        deadline_date: [],
        user: {
          name: [],
          email: [],
        },
      };
    },
  },
};
</script>

<style>
</style>