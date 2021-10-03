<template>
  <v-container>
    <v-card loading="">
      <v-toolbar color="primary lighten-4">
        <v-toolbar-title> Profile D'utilisateur </v-toolbar-title>
        <v-divider inset vertical class="mx-4"></v-divider>
      </v-toolbar>
      <v-card-text>
        <v-form @submit.prevent="handleInfoSubmit">
          <v-text-field
            label="Nom"
            v-model="form.name"
            :error-messages="errors.name"
          ></v-text-field>
          <v-text-field
            label="Email"
            type="email"
            v-model="form.email"
            :error-messages="errors.email"
          ></v-text-field>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text>Annuler</v-btn>
            <v-btn color="primary">mettre à jour</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
      <v-divider></v-divider>
      <v-toolbar color="primary lighten-4">
        <v-toolbar-title> Mot de pass </v-toolbar-title>
        <v-divider inset vertical class="mx-4"></v-divider>
      </v-toolbar>
      <v-card-text>
        <v-form @submit.prevent="handlePasswordSubmit">
          <v-text-field
            v-model="password.old"
            :error-messages="errors.password.old"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show1 ? 'text' : 'password'"
            label="Ancien mot de passe"
            @click:append="show1 = !show1"
          ></v-text-field>

          <v-text-field
            v-model="password.new"
            :error-messages="errors.password.new"
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            label="Nouveau mot de passe"
            @click:append="show2 = !show2"
          ></v-text-field>

          <v-text-field
            v-model="password.confirmation"
            :error-messages="errors.password.confirmation"
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            label="Confirmation"
            @click:append="show2 = !show2"
          ></v-text-field>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show1: false,
      show2: false,
      show3: false,
      form: {
        name: "",
        email: "",
      },
      password: {
        old: "",
        new: "",
        confirmation: "",
      },
      errors: {
        email: [],
        name: [],
        password: {
          old: [],
          new: [],
          confirmation: [],
        },
      },
    };
  },
};
</script>

<style>
</style>