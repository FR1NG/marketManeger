import axios from "axios";

export const state = {
    items: [],
    currentPage: null,
    lastPage: null,
    search: "",
    idToDelete: null,
};

export const getters = {
    items: state => state.items,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
    idToDelete: state => state.idToDelete,
    deleteDialog: state => state.idToDelete != null,
};

export const mutations = {
    setData(state, response) {
        state.items = response.data;
        state.currentPage = response.current_page;
        state.lastPage = response.last_page;
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
};

export const actions = {
    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios
                .get("fournisseur/get", {
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
                    console.log(error.response);
                });
        });
    },
    getProvider(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('fournisseur/details', {
                params: {
                    fournisseur_id: payload.id,
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
                .post("/fournisseur/store", payload.form)
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
                .delete("fournisseur/delete", {
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
            axios.patch('fournisseur/update', {
                id: provider.id,
                name: provider.name,
                phone: provider.phone,
                email: provider.email,
                address: provider.address,
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
    }
};
