<template>
  <v-container>
    <v-card>
      <v-toolbar flat color="primary  lighten-4">
        <v-toolbar-title> Details de branchement </v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
      </v-toolbar>

      <v-card-text>
        <v-row>
          <v-col
            cols="12"
            lg="4"
            md="6"
            v-for="item in details"
            :key="item.text"
          >
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title
                  class="font-weight-medium"
                  v-text="item.text"
                >
                </v-list-item-title>
                <v-list-item-subtitle
                  v-text="item.value"
                ></v-list-item-subtitle>
                <v-list-item-action-text
                  ><v-divider class="mx-4" inset vertical></v-divider
                ></v-list-item-action-text>
              </v-list-item-content>
            </v-list-item>
          </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-row>
          <v-col cols="12" md="6">
            <!-- add:BEGIN -->
            <add-article v-if="addArticlesDialog"></add-article>
            <!-- add:END -->
            <v-toolbar flat color="primary  lighten-4">
              <v-toolbar-title> List des Piéce </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn color="primary" icon @click="showAddArticles">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-toolbar>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">DSG</th>
                    <th class="text-left">Prix</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in articles" :key="item.id">
                    <td v-text="item.article.name"></td>
                    <td v-text="item.price"></td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-col>

          <v-col cols="12" md="6">
            <add-employees v-if="addEmployeesDialog"></add-employees>
            <v-toolbar flat color="primary  lighten-4">
              <v-toolbar-title> Main d'ouvre </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn color="primary" icon @click="showAddEmployees">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-toolbar>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Qualité</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in employees" :key="item.id">
                    <td v-text="item.employe.name"></td>
                    <td v-text="item.employe.quality"></td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import AddArticle from "./partials/AddArticle.vue";
import AddEmployees from "./partials/AddEmployees.vue";
export default {
  components: { AddArticle, AddEmployees },
  data() {
    return {
      loading: false,
    };
  },
  computed: {
    details() {
      return this.$store.getters["branchement/details"];
    },
    articles() {
      return this.$store.getters["branchement/articlesInBranchement"];
    },
    employees() {
      return this.$store.getters["branchement/employeesInBranchement"];
    },
    addArticlesDialog() {
      return this.$store.getters["branchement/addArticlesDialog"];
    },
    addEmployeesDialog() {
      return this.$store.getters["branchement/addEmployeesDialog"];
    },
  },
  methods: {
    getData() {
      this.$store
        .dispatch("branchement/getDetails", { id: this.$route.params.id })
        .then((response) => {
          this.loading = false;
        });
    },
    showAddArticles() {
      this.$store.commit("branchement/showAddArticles");
    },
    showAddEmployees() {
      this.$store.commit("branchement/showAddEmployees");
    },
  },
  created() {
    this.getData();
  },
};
</script>

<style>
</style>