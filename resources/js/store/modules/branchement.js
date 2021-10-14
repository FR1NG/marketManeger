import axios from "axios";

export const state = {
    loading: false,
    detailsCardLoading: false,
    branchementCategories: [],
    branchementArticles: [],
    branchements: [],
    articles: [],
    employees: [],
    cities: [],
    details: [],
    articlesInBranchement: [],
    employeesInBranchement: [],
    chargesInBranchement: [],
    currentPage: null,
    lastPage: null,
    search: '',
    addArticlesDialog: false,
    addEmployeesDialog: false,
    addChargesDialog: false,
    branchementToDeleteId: null,
    filterDialog: false,
    filter: null,

};

export const getters = {
    loading: state => state.loading,
    detailsCardLoading: state => state.detailsCardLoading,
    branchementCategories: state => state.branchementCategories,
    branchementArticles: state => state.branchementArticles,
    branchements: state => state.branchements,
    articles: state => state.articles,
    employees: state => state.employees,
    cities: state => state.cities,
    details: state => state.details,
    articlesInBranchement: state => state.articlesInBranchement,
    employeesInBranchement: state => state.employeesInBranchement,
    chargesInBranchement: state => state.chargesInBranchement,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
    addArticlesDialog: state => state.addArticlesDialog,
    addEmployeesDialog: state => state.addEmployeesDialog,
    addChargesDialog: state => state.addChargesDialog,
    deleteDialog: state => state.branchementToDeleteId !== null,
    filterDialog: state => state.filterDialog,
    filter: state => state.filter,
};

export const mutations = {
    setArticles(state, data) {
        state.articles = data.articles;
    },
    setEmployees(state, data) {
        state.employees = data.employees;
    },
    setDetails(state, data) {
        const { branchement } = data;
        state.details = [
            { text: "№ contrt", value: branchement.contract_number },
            { text: "Branchement", value: branchement.market_article.display_name },
            { text: "Type", value: branchement.type },
            { text: "Ville", value: branchement.city.name },
            { text: "Nom", value: branchement.client_name },
            { text: "Adresse", value: branchement.address },
            { text: "Intervention", value: branchement.intervention },
            { text: "№ Devis", value: branchement.estimate_number },
            { text: "№ Télephone", value: branchement.phone },
            { text: "Date D'arriver", value: branchement.arrival_date },
            { text: "Motifs", value: branchement.motive },
        ];
        state.articlesInBranchement = branchement.items;
        state.employeesInBranchement = branchement.employees;
        state.chargesInBranchement = branchement.charges;
    },

    showAddArticles(state) {
        state.addArticlesDialog = true;
    },
    hideAddArticles(state) {
        state.addArticlesDialog = false;
    },

    showAddEmployees(state) {
        state.addEmployeesDialog = true;
    },
    hideAddEmployees(state) {
        state.addEmployeesDialog = false;
    },
    showAddCharges(state) {
        state.addChargesDialog = true;
    },
    hideAddCharges(state) {
        state.addChargesDialog = false;
    },
    setData(state, data) {
        state.branchements = data.branchements.data;
        state.currentPage = data.branchements.current_page;
        state.lastPage = data.branchements.last_page;
    },
    setCurrentPage(state, data) {
        state.currentPage = data.page;
    },
    setSearch(state, data) {
        state.search = data.search;
    },
    setCreateData(state, data) {
        state.branchementCategories = data.categories;
        state.cities = data.cities;
    },
    setBranchementArticles(state, data) {
        state.branchementArticles = data.articles;
    },
    setIdToDelete(state, data) {
        state.branchementToDeleteId = data.id;
    },
    endDelete(state, data) {
        state.branchementToDeleteId = null;
    },
    showFilter(state) {
        state.filterDialog = true;
    },
    hideFilter(state) {
        state.filterDialog = false;
        state.filter = [];
    },
    setFilter(state, data) {
        state.filter = data.filter;
    }
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
    getDetails(context, payload) {
        context.state.detailsCardLoading = true;
        return new Promise((resolve, reject) => {
            axios.get('branchements/details', {
                params: {
                    id: payload.id,
                }
            })
                .then(response => {
                    // stop loading
                    context.state.detailsCardLoading = false;
                    // resolve promise
                    resolve(response);
                    // set data
                    context.commit('setDetails', response.data);
                }).catch(error => {
                    // test
                    console.log(error.response);
                    // reject
                    reject(error.response);
                })
        })
    },

    addArticles(context, payload) {
        const items = payload.items.map(element => {
            return { id: element };
        });

        return new Promise((resolve, reject) => {
            axios.post('branchements/addArticles', {
                items: items,
                branchement_id: payload.branchement_id,
            })
                .then(response => {
                    // test 
                    console.log(response);
                    // resolve
                    resolve(response);
                    // refetch data
                    context.dispatch('getDetails', { id: payload.branchement_id });
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // hide dialog
                    context.commit('hideAddArticles');

                })
                .catch(error => {
                    // refetch data if someo articles not existed
                    if (error.response.status === 405) {
                        context.dispatch('getDetails', { id: payload.branchement_id });
                        // hide dialog
                        context.commit('hideAddArticles');
                    }
                    // test
                    console.log(error.response.status);
                    // reject
                    reject(error.response);
                    // alert 
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },

    getArticles(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/branchements/getArticles')
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // set data
                    context.commit('setArticles', response.data);
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        })
    },

    getEmployees(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/branchements/getEmployees')
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // set data
                    context.commit('setEmployees', response.data);
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        })
    },
    addEmployees(context, payload) {

        return new Promise((resolve, reject) => {
            axios.post('branchements/addEmployees', {
                ...payload
            })
                .then(response => {
                    // test 
                    console.log(response);
                    // resolve
                    resolve(response);
                    // refetch data
                    context.dispatch('getDetails', { id: payload.branchement_id });
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // hide dialog
                    context.commit('hideAddEmployees');

                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject
                    reject(error.response);
                    // alert 
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },

    addCharges(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('branchements/charges/store', {
                ...payload.form,
                branchement_id: payload.branchement_id,
            })
                .then(response => {
                    //   refetch data
                    context.dispatch('getDetails', { id: payload.branchement_id })
                    // resolve
                    resolve(response);
                    // alert 
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });

                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // rejact 
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        })
    },
    getData(context, payload) {
        context.state.loading = true;
        return new Promise((resolve, reject) => {
            axios
                .get("branchements/index", {
                    params: {
                        page: context.getters.currentPage,
                        search: context.getters.search,
                        filter: context.getters.filter,
                    }
                })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // stop loading
                    context.state.loading = false;
                    // set response data
                    context.commit("setData", response.data);
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                });
        });
    },
    getCreateData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/branchements/create')
                .then(response => {
                    // resolve
                    resolve(response)
                    context.commit('setCreateData', response.data);
                })
                .catch(error => {
                    // reject
                    reject(error);
                    console.log(error.response)

                })
        })
    },
    getBranchementArticles(context, payload) {
        console.log(payload);
        return new Promise((resolve, reject) => {
            axios.get('/branchements/getBranchementArticles', {
                params: {
                    id: payload.id
                }
            })
                .then(response => {
                    // resolve
                    resolve(response)
                    context.commit('setBranchementArticles', response.data);
                })
                .catch(error => {
                    // reject
                    reject(error);
                    console.log(error.response)

                })
        })
    },

    delete(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('branchements/delete', {
                data: {
                    ...payload,
                    id: context.state.branchementToDeleteId
                }
            }).then(response => {
                // reslve 
                resolve(response);
                // refetch data
                context.dispatch('getData');
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
            }).catch(error => {
                // reject
                reject(error);
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
            });
        })
    },
    getFilterData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('branchements/filter')
                .then(response => {
                    console.log(response);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
};