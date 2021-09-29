<template>
  <v-app-bar app dense>
    <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>

    <v-spacer></v-spacer>

    <!-- <v-menu left bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>

      <v-list>
        <v-list-item link @click="logout">
          <v-list-item-icon>
            <v-icon> mdi-logout </v-icon>
          </v-list-item-icon>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu> -->

    <!-- test -->
    <v-menu left bottom offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" text>
          {{ user.name }}
          <v-icon>mdi-chevron-down</v-icon>
        </v-btn>
      </template>

      <v-card>
        <!-- BEGIN:user info -->
        <v-list max-width="300">
          <v-list-item> </v-list-item>

          <v-list-item link>
            <v-list-item-content>
              <v-list-item-title class="title d-flex justify-center">
                {{ user.name }}
              </v-list-item-title>
              <v-list-item-subtitle class="d-flex justify-center">{{
                user.email
              }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <!-- END:user info -->

        <!-- BEGIN:options -->
        <v-list nav dense>
          <!-- BEGIN:logout -->
          <v-list-item>
            <v-btn class="mx-auto" fab dark small color="error" @click="logout">
              <v-icon dark> mdi-logout-variant </v-icon>
            </v-btn>
          </v-list-item>
          <!-- END:logout -->
        </v-list>
        <!-- END:options -->
      </v-card>
    </v-menu>
    <!-- test -->
  </v-app-bar>
</template>

<script>
export default {
  data() {
    return {
      user: [],
    };
  },
  methods: {
    logout() {
      axios.post("logout").then((response) => {
        window.location.href = "login";
      });
    },
    toggleDrawer() {
      console.log("clicked");
      this.$store.commit("global/toggleDrawer");
    },
  },
  created() {
    this.user = this.$user;
  },
};
</script>

<style>
</style>