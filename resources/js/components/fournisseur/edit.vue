<template>
  <v-card class="ma-4 pa-4">
    <!-- loader:BEGIN -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <!-- loader:END -->
    <v-toolbar flat>
      <v-toolbar-title>Modifier Fournisseur</v-toolbar-title>
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
        <v-btn outlined class="mr-4">Annuler</v-btn>
        <v-btn color="success" class="mr-4" type="submit" :loading="loading"
          >Modifier
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import { useRoute } from "vue-router";
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
      errors: {
        name: [],
        phone: [],
        email: [],
        address: [],
        note: [],
      },
      loading: false,
      overlay: true,
    };
  },
  methods: {
    handleSubmit() {
      this.loading = true;
      this.$store
        .dispatch("fournisseur/update", { form: this.form })
        .then((response) => {
          this.loading = false;
          this.errors = {
            name: [],
            phone: [],
            email: [],
            address: [],
            note: [],
          };
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
    },
    getProvider() {
      this.overlay = true;
      this.$store
        .dispatch("fournisseur/getProvider", { id: this.$route.params.id })
        .then((response) => {
          const provider = response.data;
          this.form.id = provider.id;
          this.form.name = provider.name;
          this.form.phone = provider.phone;
          this.form.email = provider.email;
          this.form.address = provider.address;
          this.form.note = provider.note;
          this.overlay = false;
        })
        .catch(()=>{
            this.overlay = false;
        })
    },
  },
  created() {
    console.log(this.$route.params);
    this.getProvider();
  },
};
</script>

<style>
</style>