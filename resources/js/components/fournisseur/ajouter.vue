<template>
  <v-card class="ma-4 pa-4" :disabled="loading" :loading="loading">
    <v-toolbar flat>
      <v-toolbar-title>Ajouter Fournisseur</v-toolbar-title>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-btn
        link
        color="primary"
        dark
        class="mb-2"
        :to="{ name: 'fournisseurs' }"
      >
        List
      </v-btn>
    </v-toolbar>

    <v-form ref="form" @submit.prevent="handleSubmit">
      <v-text-field
        v-model="form.name"
        label="Nom De Fournisseur"
        :error-messages="errors.name[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.phone"
        label="Tele"
        :error-messages="errors.phone[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.email"
        label="E-mail"
        :error-messages="errors.email[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.address"
        label="Address"
        :error-messages="errors.address[0]"
      ></v-text-field>

      <v-textarea
        v-model="form.note"
        label="Note"
        :error-messages="errors.note[0]"
      ></v-textarea>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined class="mr-4" @click="resetForm">Annuler</v-btn>
        <v-btn color="success" class="mr-4" type="submit" :loading="loading"
          >Ajouter
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        phone: null,
        email: "",
        address: "",
        note: "",
      },
      loading: false,
      errors: {
        name: [],
        phone: [],
        email: [],
        address: [],
        note: [],
      },
    };
  },
  methods: {
    handleSubmit() {
      if (!this.loading) {
        this.resetErrors();
        this.loading = true;
        this.$store
          .dispatch("fournisseur/store", { form: this.form })
          .then((response) => {
            this.loading = false;
            this.resetForm();
            this.resetErrors();
          })
          .catch((error) => {
            this.loading = false;
            if (error.data) {
              error.data.errors.name
                ? (this.errors.name = error.data.errors.name)
                : (this.errors.name = []);
              error.data.errors.phone
                ? (this.errors.phone = error.data.errors.phone)
                : (this.errors.phone = []);
              error.data.errors.email
                ? (this.errors.email = error.data.errors.email)
                : (this.errors.email = []);
              error.data.errors.address
                ? (this.errors.address = error.data.errors.address)
                : (this.errors.address = []);
              error.data.errors.note
                ? (this.errors.note = error.data.errors.note)
                : (this.errors.note = []);
            }
          });
      }
    },
    resetErrors() {
      this.errors = {
        name: [],
        phone: [],
        email: [],
        address: [],
        note: [],
      };
    },
    resetForm() {
      this.resetErrors();
      this.form = {
        name: "",
        phone: null,
        email: "",
        address: "",
        note: "",
      };
    },
  },
};
</script>

<style>
</style>