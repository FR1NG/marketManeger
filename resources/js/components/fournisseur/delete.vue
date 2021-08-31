<template>
  <v-dialog v-model="deleteDialog" persistent max-width="400">
    <v-card>
      <v-card-title class="text-h5">
        êtes-vous sûr de vouloir supprimer ce fournisseur?
      </v-card-title>
      <v-card-text
        ></v-card-text
      >
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="endDelete">
          Annuler
        </v-btn>
        <v-btn color="error" @click="confirmDelete" :loading="loading"> Suprimer </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      loading : false,
    };
  },
  computed : {
      deleteDialog(){
          return this.$store.getters['fournisseur/deleteDialog'];
      }
  },
  methods : {
      endDelete(){
          this.$store.commit('fournisseur/endDelete');
      },
      confirmDelete(){
          this.loading = true
          this.$store.dispatch('fournisseur/delete')
          .then(()=> {
              this.loading = false;
          })
          .catch(()=> {
              this.loading = false;
          });
      }
  }
};
</script>

<style>
</style>