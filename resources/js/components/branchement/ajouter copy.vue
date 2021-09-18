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

    <v-form ref="form">
      <v-stepper v-model="e1">
        <v-stepper-header>
          <template>
            <v-stepper-step :step="1" editable> étape 1 </v-stepper-step>
            <v-divider></v-divider>
          </template>
          <template>
            <v-stepper-step :step="2" editable> étape 2 </v-stepper-step>
            <v-divider></v-divider>
          </template>
          <template>
            <v-stepper-step :step="3" editable> étape 3 </v-stepper-step>
          </template>
        </v-stepper-header>

        <v-stepper-items>
          <v-stepper-content :step="1">
            <v-card class="mb-12 pa-4">
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
                  <v-text-field
                    v-model="form.diameter"
                    label="DN"
                    :error-messages="errors.diameter[0]"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="form.caliber"
                    label="Calibre"
                    :error-messages="errors.caliber[0]"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="form.nature"
                    label="Nature"
                    :error-messages="errors.nature[0]"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="form.arrival_date"
                    label="Date D'arriver"
                    :error-messages="errors.arrival_date[0]"
                  ></v-text-field>
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
            </v-card>
          </v-stepper-content>

          <v-stepper-content step="2">
            <v-card class="mb-12 pa-4">
              <v-row>
                <v-col cols="12" md="6">
                  <v-select
                    label="Article"
                    :items="articles"
                    item-text="name"
                    item-value="id"
                    v-model="selectedItem.id"
                    :loading="loading"
                  >
                  </v-select>

                  <v-text-field
                    label="Prix"
                    :value="selectedItem.price"
                    readonly
                    :loading="priceLoading"
                  ></v-text-field>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="secondary">Annuler</v-btn>
                    <v-btn
                      color="primary"
                      @click="addToCart"
                      :disabled="addItemDisabled"
                      >Ajouter</v-btn
                    >
                  </v-card-actions>
                </v-col>
                <v-col cols="12" md="6">
                  <v-simple-table height="300px">
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">DSG</th>
                          <th class="text-left">Prix</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in cartItems" :key="item.article_id">
                          <td v-text="item.name"></td>
                          <td v-text="item.price"></td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                  <v-list>
                    <v-list-item>
                      <v-list-item-title class="font-weight-medium"
                        >Total :</v-list-item-title
                      >
                      <v-list-item-action-text class="font-weith-normal">
                        <h5 v-text="total"></h5>
                      </v-list-item-action-text>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>

          <!-- employees part -->
          <v-stepper-content :step="3">
            <v-card class="mb-12 pa-4">
              <v-row>
                <v-col cols="12" md="6">
                  <v-select
                    label="Article"
                    :items="articles"
                    item-text="name"
                    item-value="id"
                    v-model="selectedItem.id"
                    :loading="loading"
                  >
                  </v-select>

                  <v-text-field
                    label="Prix"
                    :value="selectedItem.price"
                    readonly
                    :loading="priceLoading"
                  ></v-text-field>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="secondary">Annuler</v-btn>
                    <v-btn
                      color="primary"
                      @click="addToCart"
                      :disabled="addItemDisabled"
                      >Ajouter</v-btn
                    >
                  </v-card-actions>
                </v-col>
                <v-col cols="12" md="6">
                  <v-simple-table height="300px">
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">DSG</th>
                          <th class="text-left">Prix</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in cartItems" :key="item.article_id">
                          <td v-text="item.name"></td>
                          <td v-text="item.price"></td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                  <v-list>
                    <v-list-item>
                      <v-list-item-title class="font-weight-medium"
                        >Total :</v-list-item-title
                      >
                      <v-list-item-action-text class="font-weith-normal">
                        <h5 v-text="total"></h5>
                      </v-list-item-action-text>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>
        </v-stepper-items>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn outlined class="mr-4">Annuler</v-btn>
          <v-btn
            v-if="e1 < 3"
            color="primary"
            class="mr-4"
            @click="nextStep(e1)"
          >
            Continue
          </v-btn>
          <v-btn
            v-else
            color="success"
            class="mr-4"
            type="submit"
            :loading="loading"
            >Enregistrer
          </v-btn>
        </v-card-actions>
      </v-stepper>

      <v-divider></v-divider>
    </v-form>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      e1: 1,
      steps: 4,
      loading: false,
      priceLoading: false,
      addItemDisabled: true,
      selectedItem: {
        id: null,
        price: null,
        warehouse_id: null,
      },
      cartItems: [],
      form: {
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
      loading: false,
      errors: {
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
    };
  },
  watch: {
    "selectedItem.id": function (newVal, oldVal) {
      if (oldVal != newVal) {
        this.getItemPrice(newVal);
      }
    },
  },
  computed: {
    articles() {
      return this.$store.getters["branchement/articles"];
    },
    total() {
      let T = 0;
      this.cartItems.forEach((element) => {
        T += parseFloat(element.price);
      });
      return T;
    },
  },
  methods: {
    nextStep(n) {
      if (n === this.steps) {
        this.e1 = 1;
      } else {
        this.e1 = n + 1;
      }
    },
    handleSubmit() {
      console.log("form submitted");
    },
    getCreateData() {
      this.loading = true;
      this.$store
        .dispatch("branchement/getCreateData")
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this, (this.loading = false);
        });
    },
    getItemPrice(id) {
      this.priceLoading = true;
      this.addItemDisabled = true;
      this.$store
        .dispatch("branchement/getItemPrice", { id: id })
        .then((response) => {
          this.selectedItem.name = response.data.item.article.name;
          this.selectedItem.price = response.data.item.price;
          this.selectedItem.warehouse_id = response.data.item.id;
          this.priceLoading = false;
          this.addItemDisabled = false;
        })
        .catch(() => {
          this.priceLoading = false;
        });
    },
    addToCart() {
      const existed = this.cartItems.some(
        (el) => el.article_id === this.selectedItem.id
      );
      if (!existed) {
        const cart = {
          warehouse_id: this.selectedItem.warehouse_id,
          article_id: this.selectedItem.id,
          name: this.selectedItem.name,
          price: this.selectedItem.price,
        };
        this.cartItems.push(cart);
      } else {
        this.$store.dispatch("toast/show", {
          text: "Cet élément est déjà sélectionné",
          type: "error",
        });
      }
      console.log(this.total);
    },
  },
  created() {
    this.getCreateData();
  },
};
</script>

<style>
</style>