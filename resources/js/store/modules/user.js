import axios from "axios";

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
    updateInfo(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('user/update', {
                ...payload.form,
            })
                .then(response => {
                    // resolve
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        })
    },
    updatePassword(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('user/password/update', {
                ...payload.form,
            })
                .then(response => {
                    // resolve
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        })
    }
};

