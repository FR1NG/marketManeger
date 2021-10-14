<template>
  <div>
    <v-row justify="center">
      <v-dialog
        :value="true"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
        scrollable
      >
        <v-card tile :disabled="loading" :loading="loading">
          <v-toolbar flat dark color="primary">
            <v-btn icon dark @click="closeDialog">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Nouvelle livraison</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleSubmit">
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.deliveryNoteNumber"
                    label="№ de bon de livraison"
                    :error-messages="errors.deliveryNoteNumber[0]"
                  >
                  </v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-menu
                    ref="date"
                    v-model="dateMenu"
                    :close-on-content-click="false"
                    :return-value.sync="form.date"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="form.date"
                        label="Date de livraison"
                        :error-messages="errors.date[0]"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="form.date" no-title scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="dateMenu = false">
                        Annuler
                      </v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.date.save(form.date)"
                      >
                        OK
                      </v-btn>
                    </v-date-picker>
                  </v-menu>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    v-model="form.deliveryMan"
                    label="Livreur"
                    :error-messages="errors.deliveryMan[0]"
                  >
                  </v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    v-model="form.deliveryCost"
                    :error-messages="errors.deliveryCost[0]"
                    type="number"
                    label="Frais de livraison"
                  >
                  </v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12">
                  <v-toolbar flat>
                    <v-toolbar-title> Articles </v-toolbar-title>
                    <v-divider inset vertical class="mx-4"></v-divider>
                  </v-toolbar>
                  <!-- =========================[items inputs:BEGIN]========================== -->
                  <v-row>
                    <v-col cols="12" md="5">
                      <v-select
                        label="Article"
                        v-model="item.article_id"
                        :loading="articlesLoading"
                        :items="articles"
                        item-text="article.name"
                        item-value="article.id"
                      ></v-select>

                      <v-text-field
                        ref="quantity"
                        v-if="item.article_id"
                        label="Quantité"
                        type="number"
                        :max="maxQuantity"
                        v-model="item.quantity"
                      >
                      </v-text-field>
                      <v-btn color="secondary" text @click="emptyItem"
                        >Annuler</v-btn
                      >
                      <v-btn color="primary" @click="addToCart">ajouter</v-btn>
                    </v-col>
                    <!-- =========================[items inputs:END]========================== -->

                    <!-- =========================[items table:begin]========================== -->
                    <v-col cols="12" md="7">
                      <v-simple-table dense>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">DSG</th>
                              <th class="text-left">Quantité</th>
                              <th class="text-left">Rest</th>
                              <th class="text-left"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in cartItems" :key="item.id">
                              <td>{{ item.name }}</td>
                              <td>{{ item.quantity }}</td>
                              <td>{{ item.rest }}</td>
                              <td>
                                <v-btn
                                  icon
                                  color="error"
                                  @click="removeFromCart(item.article_id)"
                                >
                                  <v-icon>mdi-close-circle-outline</v-icon>
                                </v-btn>
                              </td>
                            </tr>
                          </tbody>
                        </template>
                      </v-simple-table>
                    </v-col>
                    <!-- =========================[items table:END]========================== -->
                  </v-row>
                </v-col>
              </v-row>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn outlined class="mr-4" @click="resetForm">Annuler</v-btn>
                <v-btn
                  color="success"
                  class="mr-4"
                  type="submit"
                  :loading="loading"
                  >Enregistrer
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card-text>

          <div style="flex: 1 1 auto"></div>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      achat_id: null,
      form: {
        deliveryNoteNumber: null,
        date: null,
        deliveryMan: "",
        deliveryCost: null,
      },
      item: {
        name: "",
        article_id: null,
        quantity: null,
        rest: null,
      },
      cartItems: [],
      errors: {
        deliveryNoteNumber: [],
        date: [],
        deliveryMan: [],
        deliveryCost: [],
      },
      loading: false,
      articlesLoading: false,
      dateMenu: false,
    };
  },

  computed: {
    articles() {
      return this.$store.getters["achat/articlesInDetails"];
    },
    fournisseurs() {
      return this.$store.getters["achat/fournisseurs"];
    },
    total() {
      let total = 0;
      this.cartItems.forEach((item) => {
        total += item.price * item.quantity;
      });
      return total.toFixed(2);
    },
    selectedItem() {
      const item = this.articles
        .filter((element) => element.article_id == this.item.article_id)
        .shift();
      return item;
    },
    maxQuantity() {
      const maximum = this.selectedItem
        ? this.selectedItem.quantity - this.selectedItem.livred_quantity
        : 0;
      return maximum;
    },
  },
  methods: {
    closeDialog() {
      this.$store.commit("achat/hideCreateDelivery");
    },
    addToCart() {
      // if item selected and quantity setted
      if (
        this.item.article_id &&
        this.item.quantity &&
        this.item.quantity != 0
      ) {
        const exist = this.cartItems.some(
          (element) => element.article_id == this.selectedItem.article_id
        );
        // if item is already exist in cart
        if (exist) {
          this.cartItems.forEach((element) => {
            if (element.article_id == this.item.article_id) {
              if (
                this.item.quantity <= element.rest &&
                this.item.quantity <= this.maxQuantity - element.rest &&
                this.item.quantity > 0
              ) {
                const newQuantity =
                  parseInt(element.quantity) + parseInt(this.item.quantity);
                element.quantity = newQuantity;
                element.rest -= this.item.quantity;
                this.item = {};
              }
              // if quantity is not allowed
              else {
                this.$store.dispatch("toast/show", {
                  text: "La quantité sélectionnée n'est pas autorisée",
                  type: "error",
                  timeOut: 5000,
                });
              }
            }
          });
        }
        // if item not existed in cart
        else {
          //   if quantity not allowed
          if (this.item.quantity < 0 || this.item.quantity > this.maxQuantity) {
            this.$store.dispatch("toast/show", {
              text: "La quantité sélectionnée n'est pas autorisée",
              type: "error",
              timeOut: 5000,
            });
          }
          // if every thing is good
          else {
            console.log(this.selectedItem);
            const rest =
              this.selectedItem.quantity -
              this.selectedItem.livred_quantity -
              this.item.quantity;
            this.item.rest = rest;
            this.item.name = this.selectedItem.article.name;
            this.cartItems.push(this.item);
            this.emptyItem();
          }
        }
      }
      //   if item or quantity is not selected
      else {
        this.$store.dispatch("toast/show", {
          text: "Choisir un article et sa quantité ",
          type: "error",
          timeOut: 5000,
        });
      }
    },
    emptyItem() {
      this.item = {
        name: "",
        article_id: null,
        quantity: null,
        rest: null,
      };
    },
    removeFromCart(id) {
      this.cartItems = this.cartItems.filter(
        (element) => element.article_id != id
      );
    },
    handleSubmit() {
      // if ther is no item selected
      if (!(this.cartItems.length > 0)) {
        this.$store.dispatch("toast/show", {
          text: "Il n'y a pas d'élément sélectionné",
          type: "error",
          timeOut: 5000,
        });
      } else {
        if (!this.loading) {
          this.resetErrors();
          this.loading = true;
          this.$store
            .dispatch("livraison/store", {
              form: { ...this.form, achat_id: this.achat_id },
              items: this.cartItems,
            })
            .then(() => {
              this.loading = false;

              this.$store.commit("achat/hideCreateDelivery");
              this.resetForm();
              //   hide Dialog
            })
            .catch((error) => {
              console.log(error);
              this.loading = false;
              if (error.data) {
                error.data.errors.dilevery_note_number
                  ? (this.errors.deliveryNoteNumber =
                      error.data.errors.dilevery_note_number)
                  : (this.errors.deliveryNoteNumber = []);

                error.data.errors.date
                  ? (this.errors.date = error.data.errors.date)
                  : (this.errors.date = []);

                error.data.errors.delivery_man
                  ? (this.errors.deliveryMan = error.data.errors.delivery_man)
                  : (this.errors.deliveryMan = []);

                error.data.errors.delivery_cost
                  ? (this.errors.deliveryCost = error.data.errors.delivery_cost)
                  : (this.errors.deliveryCost = []);
              }
            });
        }
      }
    },
    resetErrors() {
      this.errors = {
        deliveryNoteNumber: [],
        date: [],
        deliveryMan: [],
        deliveryCost: [],
      };
    },
    resetForm() {
      this.cartItems = [];
      this.form = {
        deliveryNoteNumber: null,
        date: null,
        deliveryMan: "",
        deliveryCost: null,
      };
      this.resetErrors();
    },
    setData() {
      this.achat_id = this.$route.params.id;
    },
  },
  created() {
    this.setData();
  },
};
</script>
