<template>
  <v-card class="ma-4 pa-4">
    <v-toolbar flat>
      <v-toolbar-title>Ajouter Fournisseur</v-toolbar-title>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-btn
        link
        color="primary"
        dark
        class="mb-2"
        :to="{ name: 'fournisseur' }"
      >
        List
      </v-btn>
    </v-toolbar>

    <v-form ref="form">
      <v-text-field v-model="form.name" label="Nom De Fournisseur" required></v-text-field>

      <v-text-field v-model="form.phone" label="Tele" ></v-text-field>

      <v-text-field v-model="form.email" label="E-mail" ></v-text-field>

      <v-text-field v-model="form.address" label="Address" ></v-text-field>

      <v-textarea v-model="form.note" label="Note"></v-textarea>

      <v-card-actions>
        <v-btn color="success" class="mr-4" > Validate </v-btn>
        <v-btn color="error" class="mr-4"> Reset Form </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
export default {
    data(){
        return {
            form  : {
                name : '',
                phone : '',
                email : '',
                address : '',
                note : '',
            }
        }
    }
};
</script>

<style>
</style>