import Vue from 'vue'

Vue.prototype.$hasRole = (role) => {
    const roles = Vue.prototype.$roles;

    let result = 0;
    roles.forEach(element => {
        if (element.name === role) {
            result++;
        }
    });
    if (result > 0) {
        return true;
    }
    else {
        return false
    }
}
