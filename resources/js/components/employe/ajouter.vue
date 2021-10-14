<template>
  <v-card class="ma-4 pa-4" :disabled="loading" :loading="loading">
    <v-toolbar flat>
      <v-toolbar-title>Ajouter Employé</v-toolbar-title>
      <v-divider class="mx-4" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-btn link color="primary" dark class="mb-2" :to="{ name: 'employes' }">
        List
      </v-btn>
    </v-toolbar>

    <v-form ref="form" @submit.prevent="handleSubmit">
      <v-text-field
        v-model="form.name"
        label="Nom De L'employé"
        :error-messages="errors.name[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.cin"
        label="CIN De L'employé"
        :error-messages="errors.cin[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.cnss"
        label="Matricule CNSS"
        :error-messages="errors.cnss[0]"
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

      <v-text-field
        v-model="form.salery"
        label="Salaire De L'employé"
        type="number"
        :error-messages="errors.salery[0]"
      ></v-text-field>

      <v-text-field
        v-model="form.quality"
        label="Qualité De L'employé"
        :error-messages="errors.quality[0]"
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
        cin: "",
        cnss: "",
        phone: null,
        email: "",
        salery: null,
        quality: "",
        note: "",
      },
      errors: {
        name: [],
        cin: [],
        cnss: [],
        phone: [],
        email: [],
        address: [],
        salery: [],
        quality: [],
        note: [],
      },
      loading: false,
    };
  },
  methods: {
    handleSubmit() {
      if (!this.loading) {
        this.loading = true;
        this.$store
          .dispatch("employe/store", { form: this.form })
          .then((response) => {
            this.loading = false;
            console.log(this.errors);
            this.resetForm();
            this.resetErrors();
          })
          .catch((error) => {
            this.loading = false;
            if (error.data) {
              error.data.errors.name
                ? (this.errors.name = error.data.errors.name)
                : (this.errors.name = []);

              error.data.errors.cin
                ? (this.errors.cin = error.data.errors.cin)
                : (this.errors.cin = []);

              error.data.errors.cnss
                ? (this.errors.cnss = error.data.errors.cnss)
                : (this.errors.cnss = []);

              error.data.errors.phone
                ? (this.errors.phone = error.data.errors.phone)
                : (this.errors.phone = []);

              error.data.errors.email
                ? (this.errors.email = error.data.errors.email)
                : (this.errors.email = []);

              error.data.errors.address
                ? (this.errors.address = error.data.errors.address)
                : (this.errors.address = []);

              error.data.errors.salery
                ? (this.errors.salery = error.data.errors.salery)
                : (this.errors.salery = []);

              error.data.errors.quality
                ? (this.errors.quality = error.data.errors.quality)
                : (this.errors.quality = []);

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
        cin: [],
        cnss: [],
        phone: [],
        email: [],
        address: [],
        salery: [],
        quality: [],
        note: [],
      };
    },
    resetForm() {
      this.resetErrors();
      this.form = {
        name: "",
        cin: "",
        cnss: "",
        phone: null,
        email: "",
        salery: null,
        quality: "",
        note: "",
      };
    },
  },
};
</script>

<style>
</style>