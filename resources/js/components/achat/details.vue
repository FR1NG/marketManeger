<template>
  <v-container>
    <v-card class="pa-4" :disabled="loading" :loading="loading">
      <v-toolbar flat color="primary  lighten-4">
        <v-toolbar-title>Details</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>

        <v-btn link color="primary" dark class="mb-2" :to="{ name: 'achats' }">
          List
        </v-btn>
      </v-toolbar>
      <v-row>
        <v-col cols="12" md="5">
          <v-list>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>№ de bon de commande :</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action> {{ details.ndbc }} </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Fournisseur : </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.fournisseur ? details.fournisseur.name : "---" }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Mode de payment : </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.payment_mode }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item v-if="details.check_number">
              <v-list-item-content>
                <v-list-item-title>№ de Chèque : </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.check_number }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Montant : </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action> {{ details.amount }} Dh </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Date échéance : </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.deadline }}
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-col>

        <!-- ==========================[items table:START]======================== -->
        <v-col cols="12">
          <v-toolbar flat color="primary  lighten-4">
            <v-toolbar-title>Articles</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
          </v-toolbar>
          <v-simple-table dense>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">DSG</th>
                  <th class="text-left">Prix</th>
                  <th class="text-left">Quantité</th>
                  <th class="text-left">Quantité livrée</th>
                  <th class="text-left">rest</th>
                  <th class="text-left">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in details.items" :key="item.id">
                  <td>{{ item.article.name }}</td>
                  <td>{{ item.price }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.livred_quantity }}</td>
                  <td v-if="item.quantity - item.livred_quantity > 0">
                    {{ item.quantity - item.livred_quantity }}
                  </td>
                  <td v-else>
                    <v-chip class="ma-2" color="green" outlined>
                      totalement livrée
                    </v-chip>
                  </td>
                  <td>{{ (item.quantity * item.price).toFixed(2) }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-col>
        <!-- ==========================[items table:END]======================== -->
        <v-col cols="12">
          <v-divider></v-divider>
        </v-col>
        <!-- ==========================[delivery table:START]======================== -->
        <v-col cols="12">
          <v-toolbar flat color="primary  lighten-4">
            <v-toolbar-title>Livraisons</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="createDelivery">
              Nouvelle livraison
            </v-btn>
          </v-toolbar>
          <v-simple-table dense>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">№ de bon de livraison</th>
                  <th class="text-left">Date</th>
                  <th class="text-left">Frais de livraison</th>
                  <th class="text-left">Livreur</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in details.livraisons"
                  :key="item.id"
                  @click="toDeliveryDetails(item.id)"
                >
                  <td>{{ item.dilevery_note_number }}</td>
                  <td>{{ item.date }}</td>
                  <td>{{ item.delivery_cost }}</td>
                  <td>{{ item.delivery_man }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-col>
        <!-- ==========================[delivery table:END]======================== -->

        <!-- ==========================[create delivery :START]======================== -->
        <create-delivery v-if="createDeliveryDialog"></create-delivery>
        <!-- ==========================[create delivery :END]======================== -->
      </v-row>
    </v-card>
  </v-container>
</template>

<script>
import CreateDelivery from "./livraison/ajouter.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    CreateDelivery,
  },
  computed: {
    ...mapGetters({
      details: "achat/details",
      createDeliveryDialog: "achat/createDelivery",
      loading: "achat/detailsLoading",
    }),
    id() {
      return this.$route.params.id;
    },
  },
  methods: {
    getData() {
      this.$store.dispatch("achat/getAchatDetails", { id: this.id });
    },
    createDelivery() {
      this.$store.commit("achat/showCreateDelivery");
    },
    toDeliveryDetails(id) {
      this.$router.replace({
        name: "livraisonDetails",
        params: {
          id: id,
        },
      });
    },
  },
  created() {
    this.getData();
  },
  beforeRouteLeave(to, from, next) {
    this.$store.commit("achat/resetDetails");
    next();
  },
};
</script>

<style>
</style>