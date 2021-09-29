import axios from "axios";

export const state = {
    branchementCategories: [],
    branchementArticles: [],
    branchements: [],
    articles: [],
    employees: [],
    cities: [],
    details: [],
    articlesInBranchement: [],
    employeesInBranchement: [],
    addArticlesDialog: false,
    addEmployeesDialog: false,
    currentPage: null,
    lastPage: null,
    search: '',
};

export const getters = {
    branchementCategories: state => state.branchementCategories,
    branchementArticles: state => state.branchementArticles,
    branchements: state => state.branchements,
    articles: state => state.articles,
    employees: state => state.employees,
    cities: state => state.cities,
    details: state => state.details,
    articlesInBranchement: state => state.articlesInBranchement,
    employeesInBranchement: state => state.employeesInBranchement,
    addArticlesDialog: state => state.addArticlesDialog,
    addEmployeesDialog: state => state.addEmployeesDialog,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
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
            { text: "Nom", value: branchement.client_name },
            { text: "Adresse", value: branchement.address },
            { text: "Intervention", value: branchement.intervention },
            { text: "№ Devis", value: branchement.estimate_number },
            { text: "№ Télephone", value: branchement.phone },
            { text: "DN", value: branchement.diameter },
            { text: "Calibre", value: branchement.caliber },
            { text: "Nature", value: branchement.nature },
            { text: "Date D'arriver", value: branchement.arrival_date },
            { text: "Motifs", value: branchement.motive },
        ];
        state.articlesInBranchement = branchement.items;
        state.employeesInBranchement = branchement.employees;
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
    setData(state, data) {
        state.branchements = data.branchements.data;
        state.currentPage = data.current_page;
        state.lastPage = data.last_page;
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
        return new Promise((resolve, reject) => {
            axios.get('branchements/details', {
                params: {
                    id: payload.id,
                }
            })
                .then(response => {
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

    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios
                .get("branchements/index", {
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
};