<template>
  <v-container>
    <v-card :loading="loading" :disabled="loading">
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
            <v-btn text @click="initialize">Annuler</v-btn>
            <v-btn color="primary" type="submit">mettre à jour</v-btn>
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
            v-model="password.new_confirmation"
            :error-messages="errors.password.new_confirmation"
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            label="Confirmation"
            @click:append="show2 = !show2"
          ></v-text-field>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text @click="resetPasswordForm">Annuler</v-btn>
            <v-btn color="primary" type="submit">mettre à jour</v-btn>
          </v-card-actions>
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
      loading: false,
      form: {
        name: "",
        email: "",
      },
      password: {
        old: "",
        new: "",
        new_confirmation: "",
      },
      errors: {
        email: [],
        name: [],
        password: {
          old: [],
          new: [],
          new_confirmation: [],
        },
      },
    };
  },
  methods: {
    resetErrors() {
      this.errors = {
        email: [],
        name: [],
        password: {
          old: [],
          new: [],
          new_confirmation: [],
        },
      };
    },
    initialize() {
      this.form.name = this.$user.name;
      this.form.email = this.$user.email;
      this.resetErrors();
    },
    handleInfoSubmit() {
      if (!this.loading) {
        this.resetErrors();
        this.loading = true;
        this.$store
          .dispatch("user/updateInfo", { form: this.form })
          .then(() => {
            this.loading = false;
            window.location.reload();
          })
          .catch((error) => {
            this.loading = false;
            if (error.response) {
              const errors = error.response.data.errors;
              errors.name ? (this.errors.name = errors.name) : null;
              errors.email ? (this.errors.email = errors.email) : null;
            }
          });
      }
    },
    handlePasswordSubmit() {
      if (!this.loading) {
        this.resetErrors();
        this.loading = true;
        this.$store
          .dispatch("user/updatePassword", { form: this.password })
          .then(() => {
            this.loading = false;
            this.resetPasswordForm();
          })
          .catch((error) => {
            this.loading = false;

            if (error.response.data.errors) {
              const errors = error.response.data.errors;
              errors.old ? (this.errors.password.old = errors.old) : null;
              errors.new ? (this.errors.password.new = errors.new) : null;
              errors.new_confirmation
                ? (this.errors.password.new_confirmation =
                    errors.new_confirmation)
                : null;
              console.log(errors);
            }
          });
      }
    },
    resetPasswordForm() {
      this.resetErrors();
      this.password = {
        old: "",
        new: "",
        new_confirmation: "",
      };
    },
  },
  mounted() {
    this.initialize();
  },
};
</script>

<style>
</style>