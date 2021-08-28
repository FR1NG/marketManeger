<template>
  <v-app-bar
    app
      dense
      
    >
      <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>

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
</template>

<script>
export default {
 methods : {
        logout(){
            axios.post('logout')
            .then(response =>{
                window.location.href = 'login';
            })
        },
        toggleDrawer(){
            console.log("clicked")
            this.$store.commit('global/toggleDrawer');
        }
    }
}
</script>

<style>

</style>