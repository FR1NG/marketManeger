import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import colors from "vuetify/lib/util/colors";
import "mdi-icons/css/materialdesignicons.min.css";
import fr from 'vuetify/lib/locale/fr';


Vue.use(Vuetify)

const opts = {
    theme: {
        icons: {
            iconfont: 'mdi', // default - only for display purposes
        },
        options: { customProperties: true },
        dark: localStorage.getItem('darkMode'),
        themes: {
            light: {
                primary: colors.purple,
                secondary: colors.grey.darken1,
                accent: colors.shades.black,
                error: colors.red.accent3,
                white: colors.white
            },
            dark: {
                white: '#000000',
                primary: localStorage.getItem('primaryColor') || colors.purple,
            }
        }
    },
    lang: {
        locales: {
            fr,
        },
        current: 'fr'
    }
}

export default new Vuetify(opts)