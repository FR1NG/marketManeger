<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <!--  -->

       <v-list
          dense
          rounded
        >
          <v-list-item link to="dashboard">
            <v-list-item-icon>
              <v-icon>mdi-laptop</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>


           <v-list-item link to="contact">
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>contact</v-list-item-title>
            </v-list-item-content>
          </v-list-item>


        </v-list>

    </v-navigation-drawer>


    <v-app-bar
    app
      color="deep-purple accent-4"
      dense
      dark
    >
      <v-app-bar-nav-icon @click="drawer= !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Page title</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item link @click="logout">
              <v-list-item-icon>
                  <v-icon>
                      mdi-logout
                  </v-icon>
              </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-main>
      <!--  -->
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({ drawer: null }),
    methods : {
        logout(){
            axios.post('logout')
            .then(response =>{
                window.location.href = 'login';
            })
        }
    }
  }
</script>
