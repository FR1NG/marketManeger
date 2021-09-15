<template>
  <v-container>
    <v-card class="pa-4">
      <v-toolbar flat>
        <v-toolbar-title>Details de livraison</v-toolbar-title>
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
                <v-list-item-title
                  ><p class="font-weight-black">
                    № de bon de commande :
                  </p></v-list-item-title
                >
              </v-list-item-content>
              <v-list-item-action>
                {{ details.achat.ndbc }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <p class="font-weight-black">№ de bon de livraison :</p>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.dilevery_note_number }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <p class="font-weight-black">Livreur :</p>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.delivery_man }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <p class="font-weight-black">Date de livraison :</p>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.date }}
              </v-list-item-action>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <p class="font-weight-black">Frais de livraison :</p>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                {{ details.delivery_cost }}
              </v-list-item-action>
            </v-list-item>
          </v-list>
        </v-col>

        <!-- ==========================[items table:START]======================== -->
        <v-col cols="12">
          <v-divider></v-divider>
          <v-toolbar flat>
            <v-toolbar-title>Articles</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
          </v-toolbar>
          <v-simple-table dense>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">DSG</th>
                  <th class="text-left">Quantité</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in details.items_in_delivery" :key="item.id">
                  <td>{{ item.article.name }}</td>
                  <td>{{ item.quantity }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-col>
        <!-- ==========================[items table:END]======================== -->
        <v-col cols="12">
          <v-divider></v-divider>
        </v-col>
      </v-row>
    </v-card>
  </v-container>
</template>

<script>
export default {
  computed: {
    id() {
      return this.$route.params.id;
    },
    details() {
      return this.$store.getters["livraison/details"];
    },
  },
  methods: {
    getData() {
      this.$store.dispatch("livraison/getLivraisonDetails", { id: this.id });
    },
  },
  created() {
    this.getData();
  },
  beforeRouteLeave(to, from, next) {
    this.$store.commit("livraison/resetDetails");
    next();
  },
};
</script>

<style>
</style>