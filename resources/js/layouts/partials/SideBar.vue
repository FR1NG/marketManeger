<template>
  <v-navigation-drawer v-model="drawer" app>
    <v-list dense>
      <v-list-item>
        <v-list-item-avatar>
          <img src="/assets/brand_icon.png" alt="logo" />
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>
            <h1 class="font-weight-light">Meediaty</h1>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item
        v-for="link in links"
        :key="link.test"
        link
        :to="{ name: link.path }"
      >
        <v-list-item-icon>
          <v-icon>{{ link.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ link.text }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      links: [
        { text: "Tableau de bord", icon: "mdi-laptop", path: "dashboard" },
        { text: "Achat", icon: "mdi-cart-outline", path: "achats" },
        { text: "Employé", icon: "mdi-account-outline", path: "employes" },
        {
          text: "Fournisseur",
          icon: "mdi-truck-outline",
          path: "fournisseurs",
        },
        { text: "Dépot", icon: "mdi-warehouse", path: "depot" },
        { text: "Branchement", icon: "mdi-tools", path: "branchements" },
        { text: "Paramètres", icon: "mdi-tune", path: "parametres" },
      ],
    };
  },
  computed: {
    drawer: {
      get() {
        return this.$store.getters["global/navigationDrawer"];
      },
      set(value) {
        this.$store.commit("global/setDrawer", value);
      },
    },
  },
};
</script>

<style lang="scss">
/* a.v-list-item--active.v-list-item.v-list-item--link.theme--light {
  background: #e53935;
  color: #fff;
}

a.v-list-item {
  color: rgba(0, 0, 0, 0.068);
}
a.v-list-item.v-list-item--link.theme--light:hover {
  text-decoration: none;
} */
//light mode
.theme--light {
  &.v-list-item--active {
    color: var(--v-primary-lighten3) !important;
  }
}
//darl mode
.theme--dark {
  &.v-list-item--active {
    color: var(--v-primary-lighten3) !important;
  }
}
</style>