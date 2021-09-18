import axios from "axios";

export const state = {
    articles: [],
};

export const getters = {
    articles: state => state.articles,
};

export const mutations = {
    setCreateData(state, data) {
        state.articles = data.articles;
    },
};

export const actions = {
    store(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('branchements/store', {
                ...payload.form,
            })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                })
                .catch(error => {
                    // reject
                    reject(error.response)
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        })
    },

    getCreateData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/branchements/create')
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // set data
                    context.commit('setCreateData', response.data);
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        })
    },
    getItemPrice(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/branchements/getItemPrice', {
                params: {
                    id: payload.id
                }
            }).then(response => {
                // resolve promise
                resolve(response);
            })
                .catch(error => {
                    // reject promise
                    reject(error.resonse);
                    // alert (toast)
                    context.dispatch('toast/show', { text: error.response.data.message, type: "error" }, { root: true });
                    // test
                    console.log(error.response);
                })
        });
    }
};