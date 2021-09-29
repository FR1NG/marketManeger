<template>
  <v-card class="ma-4 pa-4">
    <v-toolbar flat>
      <v-toolbar-title>Nouveau Branchement</v-toolbar-title>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-btn
        link
        color="primary"
        dark
        class="mb-2"
        :to="{ name: 'branchements' }"
      >
        List
      </v-btn>
    </v-toolbar>

    <v-form ref="form" @submit.prevent="handleSubmit">
      <v-row>
        <v-col cols="12" md="6">
          <v-select
            v-model="selectedCategory"
            label="Catégorie de branchement"
            :loading="categoriesLoading"
            :items="categories"
            item-text="name"
            item-value="id"
          ></v-select>
        </v-col>

        <v-col cols="12" md="6">
          <v-select
            v-model="form.market_article_id"
            :items="branchementArticles"
            item-text="display_name"
            item-value="id"
            :loading="articlesLoading"
            label="Branchement"
            :error-messages="errors.market_article_id"
          ></v-select>
        </v-col>

        <v-col cols="12" md="6">
          <v-select
            v-model="form.type"
            label="Type"
            :items="['normal', 'social']"
            :error-messages="errors.type"
          ></v-select>
        </v-col>

        <v-col cols="12" md="6">
          <v-select
            v-model="form.city"
            label="Ville"
            :items="cities"
            item-text="name"
            item-value="id"
            :error-messages="errors.city"
          ></v-select>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.contract_number"
            label="№ contrt"
            :error-messages="errors.contract_number[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.client_name"
            label="Nom"
            :error-messages="errors.client_name[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.intervention"
            label="Intervention"
            :error-messages="errors.intervention[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.estimate_number"
            label="№ Devis"
            :error-messages="errors.estimate_number[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.phone"
            label="№ Télephone"
            :error-messages="errors.phone[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-select
            :items="dns"
            v-model="form.diameter"
            label="DN"
            :error-messages="errors.diameter[0]"
          ></v-select>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.caliber"
            label="Calibre"
            :error-messages="errors.caliber[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6">
          <v-select
            :items="natures"
            v-model="form.nature"
            label="Nature"
            :error-messages="errors.nature[0]"
          ></v-select>
        </v-col>

        <v-col cols="12" md="6">
          <v-dialog
            ref="dialog"
            v-model="dateModal"
            :return-value.sync="form.arrival_date"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.arrival_date"
                label="Date D'arriver"
                :error-messages="errors.arrival_date[0]"
                readonly
                append-icon="mdi-calendar"
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.arrival_date" scrollable>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="dateModal = false">
                Annuler
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="$refs.dialog.save(form.arrival_date)"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-dialog>
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.motive"
            label="Motifs"
            :error-messages="errors.motive[0]"
          ></v-text-field>
        </v-col>

        <v-col cols="12">
          <v-text-field
            v-model="form.address"
            label="Adresse"
            :error-messages="errors.address[0]"
          ></v-text-field>
        </v-col>
      </v-row>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined class="mr-4">Annuler</v-btn>

        <v-btn color="success" class="mr-4" type="submit" :loading="loading"
          >Enregistrer
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
      dateModal: false,
      loading: false,
      categoriesLoading: false,
      articlesLoading: false,
      selectedCategory: null,
      form: {
        market_article_id: null,
        type: "",
        city: null,
        contract_number: "",
        client_name: "",
        address: "",
        intervention: "",
        phone: "",
        estimate_number: "",
        diameter: "",
        caliber: "",
        nature: "",
        arrival_date: "",
        motive: "",
      },
      errors: {
        market_article_id: [],
        type: [],
        city: [],
        contract_number: [],
        client_name: [],
        address: [],
        intervention: [],
        phone: [],
        estimate_number: [],
        diameter: [],
        caliber: [],
        nature: [],
        arrival_date: [],
        motive: [],
      },
      dns: ["21*32", "26*40", "33*50", "26*40*2", "33*5*2", "DEP"],
      natures: ["3éme CPT", "2éme CPT", "3éme CPT", "2éme et 3éme CPT", "NBN"],
    };
  },
  watch: {
    selectedCategory() {
      this.getArticles({ id: this.selectedCategory });
    },
  },
  computed: {
    ...mapGetters({
      categories: "branchement/branchementCategories",
      branchementArticles: "branchement/branchementArticles",
      cities: "branchement/cities",
    }),
  },
  methods: {
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("branchement/store", { form: this.form })
        .then((response) => {
          // stop loading
          this.loading = false;
          //   reset errors
          //   this.resetErrors();
          //   succeed functions
          this.storeSucceed(response);
        })
        .catch((error) => {
          console.log(error);
          // stop loading
          this.loading = false;
          // push errors
          //   this.pushErrors(error);
          error.data.errors.market_article_id
            ? (this.errors.market_article_id =
                error.data.errors.market_article_id)
            : null;
          error.data.errors.type
            ? (this.errors.type = error.data.errors.type)
            : null;
          error.data.errors.city
            ? (this.errors.city = error.data.errors.city)
            : null;
          error.data.errors.contract_number
            ? (this.errors.contract_number = error.data.errors.contract_number)
            : (this.errors.contract_number = []);
          error.data.errors.client_name
            ? (this.errors.client_name = error.data.errors.client_name)
            : (this.errors.client_name = []);
          error.data.errors.address
            ? (this.errors.address = error.data.errors.address)
            : (this.errors.address = []);
          error.data.errors.intervention
            ? (this.errors.intervention = error.data.errors.intervention)
            : (this.errors.intervention = []);
          error.data.errors.estimate_number
            ? (this.errors.estimate_number = error.data.errors.estimate_number)
            : (this.errors.estimate_number = []);
          error.data.errors.phone
            ? (this.errors.phone = error.data.errors.phone)
            : (this.errors.phone = []);
          error.data.errors.diameter
            ? (this.errors.diameter = error.data.errors.diameter)
            : (this.errors.diameter = []);
          error.data.errors.caliber
            ? (this.errors.caliber = error.data.errors.caliber)
            : (this.errors.caliber = []);
          error.data.errors.nature
            ? (this.errors.nature = error.data.errors.nature)
            : (this.errors.nature = []);
          error.data.errors.arrival_date
            ? (this.errors.arrival_date = error.data.errors.arrival_date)
            : (this.errors.arrival_date = []);
          error.data.errors.motive
            ? (this.errors.motive = error.data.errors.motive)
            : (this.errors.motive = []);
        });
    },
    pushErrors(error) {
      console.log("push errors");
    },
    resetErrors() {
      this.errors = {
        market_article_id: [],
        type: [],
        contract_number: [],
        client_name: [],
        address: [],
        intervention: [],
        phone: [],
        estimate_number: [],
        diameter: [],
        caliber: [],
        nature: [],
        arrival_date: [],
        motive: [],
      };
    },
    storeSucceed(response) {
      this.$router.replace({
        name: "branchementDetails",
        params: {
          id: response.data.branchement_id,
        },
      });
    },
    getCategories() {
      this.categoriesLoading = true;
      this.$store.dispatch("branchement/getCreateData").then(() => {
        this.categoriesLoading = false;
      });
    },
    getArticles({ id }) {
      this.articlesLoading = true;
      this.$store
        .dispatch("branchement/getBranchementArticles", { id })
        .then(() => {
          this.articlesLoading = false;
        });
    },
  },
  created() {
    this.getCategories();
  },
};
</script>

<style>
</style>