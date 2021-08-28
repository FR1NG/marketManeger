<template>
  <v-navigation-drawer v-model="drawer" app>
         <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6">
            Application
          </v-list-item-title>
          <v-list-item-subtitle>
            subtext
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

    <v-list dense >
      <v-list-item v-for="link in links" :key="link.test" link :to="link.path">
        <v-list-item-icon>
          <v-icon>{{link.icon}}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{link.text}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
    data(){
        return {
            links : [
                {text : 'Tableau de bord', icon : 'mdi-laptop', path : '/dashboard'},
                {text : 'Achat', icon : 'mdi-cart-outline', path : '/achat'},
                {text : 'Employé', icon : 'mdi-account-outline', path : '/employe'},
                {text : 'Fournisseur', icon : 'mdi-truck-outline', path : '/fournisseur'},
                {text : 'Branchement', icon : 'mdi-tools', path : '/branchement'},
                {text : 'Paramètres', icon : 'mdi-tune', path : '/parametre'},
            ]
        }
    },
    computed : {
        drawer : {
            get(){
                return this.$store.getters['global/navigationDrawer'];
            },
            set(value){
                this.$store.commit('global/setDrawer',value);
            }
        }
    },
    created(){
        console.log(this.links);
    }
};
</script>

<style>
a.v-list-item--active.v-list-item.v-list-item--link.theme--light {
    background: #0000007d;
    color: #fff;
}

a.v-list-item {
color: rgba(0, 0, 0, 0.068);
}
a.v-list-item.v-list-item--link.theme--light:hover {
text-decoration: none;
}
</style>