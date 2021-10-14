import axios from "axios";

export const state = {
    info: [],
    articles: [],
    cities: [],
    loading: false,
    createCategoryDialog: false,
    categoryToCreateOnId: null,
    categoryIdToDelete: null,
};

export const getters = {
    info: state => state.info,
    articles: state => state.articles,
    cities: state => state.cities,
    loading: state => state.loading,
    createCategoryDialog: state => state.createCategoryDialog,
    createArticleDialog: state => state.categoryToCreateOnId != null,
    categoryToCreateOnId: state => state.categoryToCreateOnId,
    categoryIdToDelete: state => state.categoryIdToDelete,
    deleteCategoryDialog: state => state.categoryIdToDelete !== null,

};

export const mutations = {
    setInfo(state, data) {
        console.log(data);
        state.info = data.market
    },
    startLoading(state) {
        state.loading = true;
    },
    stopLoading(state) {
        state.loading = false;
    },
    showCreateCategoryDialog(state) {
        state.createCategoryDialog = true;
    },
    hideCreateCategoryDialog(state) {
        state.createCategoryDialog = false;
    },
    showCreateArticleDialog(state, data) {
        state.categoryToCreateOnId = data.id;
    },
    hideCreateArticleDialog(state) {
        state.categoryToCreateOnId = null;
    },
    setArticles(state, data) {
        state.articles = data.articles;
    },
    setCities(state, data) {
        state.cities = data.cities;
    },
    setCategoryDelete(state, data) {
        state.categoryIdToDelete = data.id;
    },
    endCategoryDelete(state) {
        state.categoryIdToDelete = null;
    },
    setRemoveCityLoading(state, data) {
        state.cities = state.cities.map(el => {
            if (el.id == data.id) {
                el.removeLoading = true;
            }
            return el;
        });
    },
    endRemoveCityLoading(state, data) {
        state.cities = state.cities.map(el => {
            if (el.id == data.id) {
                el.removeLoading = false;
            }
            return el;
        });
    },
};

export const actions = {
    getInfo(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('admin/markets/info', {
                params: {
                    id: payload.id
                }
            })
                .then(response => {
                    // test 
                    console.log(response);
                    // resolve
                    resolve(response);
                    // set data
                    context.commit('setInfo', response.data);
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                })

        });
    },
    storeCategory(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('admin/markets/categories/store', {
                ...payload
            })
                .then(response => {
                    // test
                    console.log(response);
                    // resolve
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // hide dialog
                    context.commit('hideCreateCategoryDialog');
                    // refetsh data
                    context.dispatch('gatArticles', { market_id: payload.market_id });
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject 
                    reject(error);
                    // alert 
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        });
    },
    gatArticles(context, payload) {
        context.commit('startLoading');
        return new Promise((resolve, reject) => {
            axios.get('/admin/markets/categories/getData', {
                params: {
                    market_id: payload.market_id
                }
            })
                .then(response => {
                    console.log(response);
                    // resolve
                    resolve(response);
                    // set Data
                    context.commit('setArticles', response.data);
                    // stop loading
                    context.commit('stopLoading');

                })
                .catch(error => {
                    console.log(error.response);

                    // reject
                    reject(error);

                })
        })
    },
    storeArticle(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/markets/articles/store', {
                market_category_id: context.state.categoryToCreateOnId,
                market_id: payload.market_id,
                ...payload.form,
            })
                .then(response => {
                    // resolve
                    resolve(response);
                    // refetch data
                    context.dispatch('gatArticles', { market_id: payload.market_id });
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                })
                .catch(error => {
                    // reject
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        })
    },
    getCities(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('admin/markets/cities/get', {
                params: {
                    market_id: payload.market_id
                }
            })
                .then(response => {
                    // test
                    console.log(response);
                    // set data 
                    context.commit('setCities', response.data);

                })
                .catch(error => {
                    console.log(error.response)

                })
        })
    },
    storeCity(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('admin/markets/cities/store', {
                name: payload.name,
                market_id: payload.market_id
            })
                .then(response => {
                    // resolve
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    updateInfo(context, payload) {
        return new Promise((resolve, reject) => {
            axios.patch('admin/markets/update', {
                ...payload.form,
            }).then(response => {
                // test
                console.log(response);
                // resolve
                resolve(response);
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
            }).catch(error => {
                // test
                console.log(error.response);
                // reject
                reject(error);
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
            });
        });
    },
    deleteCategory(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('admin/markets/categories/delete', {
                data: {
                    id: context.getters.categoryIdToDelete,
                }
            }).then(response => {
                // resolve
                resolve(response);
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                // end delete 
                context.commit('endCategoryDelete');
                // refetsh data
                context.dispatch('gatArticles', { market_id: payload.market_id });
            }).catch(error => {
                // reject
                reject(error);
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
            });
        });
    },
    deleteCity(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('admin/markets/cities/delete', {
                data: {
                    id: payload.id
                }
            }).then(response => {
                // resolve
                resolve(response);
                // stop loading
                context.commit('endRemoveCityLoading', { id: payload.id });
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                // refetsh data
                context.dispatch('getCities', { market_id: payload.market_id });
            }).catch(error => {
                // reject
                reject(error);
                // stop loading
                context.commit('endRemoveCityLoading', { id: payload.id });
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
            });
        });
    }
};

