<template>
  <v-dialog
    v-model="deleteDialog"
    persistent
    max-width="430"
    :disabled="loading"
    :loading="loading"
  >
    <v-card>
      <v-card-title class="text-h5">
        êtes-vous sûr de vouloir supprimer ce branchement?
      </v-card-title>
      <v-card-text>
        <v-checkbox v-model="changeWarehouse">
          <template v-slot:label>
            <div>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <div v-on="on">retourner les pièces à l'entrepôt</div>
                </template>
                si cette case est cochée tous les produits utilisés dans ce
                branchement seront retourner en l'entrepôt
              </v-tooltip>
            </div>
          </template>
        </v-checkbox>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="endDelete"> Annuler </v-btn>
        <v-btn color="error" @click="confirmDelete" :loading="loading">
          Suprimer
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      changeWarehouse: false,
    };
  },
  computed: {
    deleteDialog() {
      return this.$store.getters["branchement/deleteDialog"];
    },
  },
  methods: {
    endDelete() {
      this.$store.commit("branchement/endDelete");
    },
    confirmDelete() {
      this.loading = true;
      this.$store
        .dispatch("branchement/delete", {
          change_warehouse: this.changeWarehouse,
        })
        .then(() => {
          this.loading = false;
          this.endDelete();
        })
        .catch(() => {
          this.loading = false;
          this.endDelete();
        });
    },
  },
};
</script>

<style>
</style>