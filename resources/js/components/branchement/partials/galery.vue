<template>
  <div>
    <v-dialog
      :value="true"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      scrollable
    >
      <v-card tile :loading="uploadLoading" :disabled="uploadLoading">
        <v-toolbar flat dark color="primary">
          <v-btn icon dark @click="hideDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Photos de branchement</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-dialog v-model="uploadDialog" width="500">
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon dark v-bind="attrs" v-on="on">
                  <v-icon>mdi-cloud-upload-outline</v-icon>
                </v-btn>
              </template>

              <v-card :disabled="uploadLoading" :loading="uploadLoading">
                <v-card-title class="text-h5 grey lighten-2">
                  Télécharger une image
                </v-card-title>

                <v-card-text>
                  <v-form
                    @submit.prevent="handleSubmit"
                    enctype="multipart/form-data"
                  >
                    <v-file-input
                      truncate-length="20"
                      v-model="image"
                      :error-messages="errors.image"
                    ></v-file-input>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn text @click="hideUploadDialog"> Annuler </v-btn>
                      <v-btn color="primary" type="submit">Télécharger</v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card-text>

                <v-divider></v-divider>
              </v-card>
            </v-dialog>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-row>
            <v-col
              v-for="image in images"
              :key="image.id"
              class="d-flex child-flex"
              cols="12"
              md="4"
            >
              <v-img
                :src="`/storage/branchements/${image.branchement_id}/${image.name}`"
                aspect-ratio="1"
                class="grey lighten-2"
              >
                <template v-slot:placeholder>
                  <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                  >
                    <v-progress-circular
                      indeterminate
                      color="grey lighten-5"
                    ></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-col>
          </v-row>
          <v-pagination
            v-model="currentPage"
            class="py-4"
            :length="lastPage"
            :total-visible="8"
          ></v-pagination>
        </v-card-text>
        <div style="flex: 1 1 auto"></div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      uploadLoading: false,
      uploadDialog: false,
      image: null,
      errors: {
        image: [],
      },
    };
  },
  computed: {
    currentPage: {
      get() {
        return this.$store.getters["galery/currentPage"];
      },
      set(val) {
        this.$store.commit("galery/setCurrentPage", { page: val });
      },
    },
    lastPage() {
      return this.$store.getters["galery/lastPage"];
    },
    images() {
      return this.$store.getters["galery/images"];
    },
  },
  methods: {
    handleSubmit() {
      if (!this.uploadLoading) {
        this.uploadLoading = true;
        let formData = new FormData();
        formData.append("file", this.image);
        formData.append("branchement_id", this.$route.params.id);
        const config = {
          headers: {
            "content-type": "multipart/form-data",
          },
        };
        this.$store
          .dispatch("galery/uploadImage", {
            formData,
            config,
          })
          .then(() => {
            this.uploadLoading = false;
            this.getImages();
            this.hideUploadDialog();
          })
          .catch((error) => {
            this.uploadLoading = false;
            error.response.data.errors
              ? (this.errors.image = error.response.data.errors.file)
              : null;
          });
      }
    },
    getImages() {
      this.$store.dispatch("galery/getImages", {
        branchement_id: this.$route.params.id,
      });
    },
    hideUploadDialog() {
      this.uploadDialog = false;
      this.image = null;
    },
    hideDialog() {
      this.$store.commit("galery/hideGaleryDialog");
    },
  },
  created() {
    this.getImages();
  },
};
</script>