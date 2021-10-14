import axios from "axios";

export const state = {
    markets: [],
    lastPage: null,
    currentPage: null,
    search: null,
    toDelete: null,
};

export const getters = {
    markets: state => state.markets,
    lastPage: state => state.lastPage,
    currentPage: state => state.currentPage,
    search: state => state.search,
    toDelete: state => state.toDelete,
    deleteDialog: state => state.toDelete != null,
};

export const mutations = {
    setData(state, data) {
        state.markets = data.markets.data;
        state.currentPage = data.markets.current_page;
        state.lastPage = data.markets.last_page;
    },
    setSearch(state, data) {
        state.search = data.search
    },
    setCurrentPage(state, data) {
        state.currentPage = data.page;
    },
    setDelete(state, data) {
        state.toDelete = data;
    },
    endDelete(state) {
        state.toDelete = null;
    }
};

export const actions = {
    store(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('admin/markets/store', {
                ...payload.form
            })
                .then(Response => {
                    // resolve
                    resolve(Response);
                    // alert
                    context.dispatch('alert/show', { text: Response.data.message, type: 'success' }, { root: true });

                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject
                    reject(error);
                })
        })
    },
    getData(context, state) {
        return new Promise((resolve, reject) => {
            axios.get('/admin/markets', {
                search: context.state.search,
                page: context.state.currentPage,
            })
                .then(response => {
                    // resolve
                    resolve(response);
                    // set data
                    context.commit('setData', response.data);
                })
                .catch(error => {
                    // reject
                    reject(error.response);
                })
        })
    },
    delete(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('admin/markets/delete', {
                data: {
                    id: context.getters.toDelete.id,
                    password: payload.password,
                }
            }).then(response => {
                // resolve
                resolve(response);
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
            }).catch(error => {
                // reject
                reject(error);
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

            })
        })
    }
};

