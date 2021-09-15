import axios from "axios";

export const state = {
    items: [],
    currentPage: null,
    lastPage: null,
    search: "",
    idToDelete: null,
    articles: [],
    fournisseurs: [],
    details: {
        fournisseur: {}
    },
    articlesInDetails: [],
    createDelivery: false,
    deliveryInDetails: [],
};

export const getters = {
    items: state => state.items,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
    idToDelete: state => state.idToDelete,
    deleteDialog: state => state.idToDelete != null,
    articles: state => state.articles,
    fournisseurs: state => state.fournisseurs,
    details: state => state.details,
    articlesInDetails: state => state.articlesInDetails,
    createDelivery: state => state.createDelivery,
    createDelideliveryInDetailsvery: state => state.deliveryInDetails,
};

export const mutations = {
    setData(state, response) {
        state.items = response.achats.data;
        state.currentPage = response.achats.current_page;
        state.lastPage = response.achats.last_page;
    },
    setCurrentPage(state, data) {
        state.currentPage = data.page;
    },
    setSearch(state, data) {
        state.search = data.search;
    },
    setDelete(state, data) {
        state.idToDelete = data.id;
    },
    endDelete(state) {
        state.idToDelete = null;
    },
    setCreateData(state, data) {
        state.articles = data.articles;
        state.fournisseurs = data.fournisseurs;
    },
    setDetails(state, data) {
        state.details = data.achat;
        state.articlesInDetails = data.achat.items;
        state.deliveryInDetails = data.achat.livraisons;
    },
    resetDetails(state) {
        state.details = {
            fournisseur: {},
        }
    },
    showCreateDelivery(state) {
        state.createDelivery = true;
    },
    hideCreateDelivery(state) {
        state.createDelivery = false;
    },
};

export const actions = {
    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios
                .get("achats/index", {
                    params: {
                        page: context.state.currentPage,
                        search: context.state.search
                    }
                })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // set response data
                    context.commit("setData", response.data);
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                });
        });
    },
    getAchat(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('achats/details', {
                params: {
                    id: payload.id,
                }
            })
                .then(response => {
                    // resolve Promise
                    resolve(response);
                })
                .catch(error => {
                    // reject Promise
                    reject(error.response);

                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    store(context, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post("/achats/store", {
                    ndbc: payload.form.ndbc,
                    fournisseur: payload.form.fournisseur,
                    payment_mode: payload.form.paymentMode,
                    check_number: payload.form.checkNumber,
                    deadline: payload.form.deadline,
                    amount: payload.amount,
                    items: payload.items
                })
                .then(response => {
                    // resolve promise
                    resolve(response);

                    // alert
                    context.dispatch(
                        "alert/show",
                        { text: response.data.message, type: "success" },
                        { root: true }
                    );
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);

                    // alert
                    context.dispatch(
                        "alert/show",
                        { text: error.response.data.message, type: "error" },
                        { root: true }
                    );
                });
        });
    },
    delete(context) {
        return new Promise((resolve, reject) => {
            axios
                .delete("achats/delete", {
                    data: {
                        id: context.state.idToDelete
                    }
                })
                .then(response => {
                    // resolve promise
                    resolve(response);

                    // end delete process
                    context.commit("endDelete");

                    // refetch data
                    context.dispatch("getData");

                    // alert
                    context.dispatch(
                        "alert/show",
                        { text: response.data.message, type: "success" },
                        { root: true }
                    );
                })
                .catch(error => {
                    // reject Promise
                    reject(error.response);

                    // alert
                    context.dispatch(
                        "alert/show",
                        { text: error.response.data.message, type: "error" },
                        { root: true }
                    );

                    // end delete process
                    context.commit("endDelete");
                });
        });
    },
    update(context, payload) {
        const provider = payload.form;
        return new Promise((resolve, reject) => {
            axios.patch('achats/update', {
                id: provider.id,
                name: provider.name,
                cin: provider.cin,
                cnss: provider.cnss,
                phone: provider.phone,
                email: provider.email,
                address: provider.address,
                salery: provider.salery,
                quality: provider.quality,
                note: provider.note,
            })
                .then(response => {

                    // resolve promise
                    resolve(response);

                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                })
                .catch(error => {

                    // reject Promise
                    reject(error.response);

                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        })
    },

    getCreateData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('achats/create')
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // set data
                    context.commit('setCreateData', response.data);
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                })
        });
    },
    getAchatDetails(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('achats/details', {
                params: {
                    id: payload.id,
                }
            })
                .then(response => {
                    // resolve promise 
                    resolve(response);
                    // set data
                    context.commit('setDetails', response.data);
                })
                .catch(error => {
                    console.log(error.response);
                })
        })
    }
};
