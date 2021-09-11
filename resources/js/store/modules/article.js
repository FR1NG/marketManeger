import axios from "axios";

export const state = {
    // categories states
    createCategoryDialog: false,
    categories: [],
    editCategoryDialog: false,
    categoryToEdit: [],
    categoryIdToDelete: null,
    // units states
    createUnitDialog: false,
    units: [],
    editUnitDialog: false,
    unitToEdit: [],
    unitIdToDelete: null,
    // articles states
    createArticleDialog: false,
    articles: [],
    editArticleDialog: false,
    articleToEdit: [],
    articleIdToDelete: null,
    currentPage: null,
    lastPage: null,
    search: '',

}
export const getters = {
    // categories getters
    createCategoryDialog: state => state.createCategoryDialog,
    categories: state => state.categories,
    editCategoryDialog: state => state.editCategoryDialog,
    categoryToEdit: state => state.categoryToEdit,
    categoryIdToDelete: state => state.categoryIdToDelete,
    categoryDeleteDialog: state => state.categoryIdToDelete != null,
    // units getters
    createUnitDialog: state => state.createUnitDialog,
    units: state => state.units,
    editUnitDialog: state => state.editUnitDialog,
    unitToEdit: state => state.unitToEdit,
    unitIdToDelete: state => state.unitIdToDelete,
    unitDeleteDialog: state => state.unitIdToDelete != null,
    // articles getters
    createArticleDialog: state => state.createArticleDialog,
    articles: state => state.articles,
    editArticleDialog: state => state.editArticleDialog,
    articleToEdit: state => state.articleToEdit,
    articleIdToDelete: state => state.articleIdToDelete,
    articleDeleteDialog: state => state.articleIdToDelete != null,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
}
export const mutations = {
    // categories mutations:BEGIN
    showCreateCategoryDialog(state) {
        state.createCategoryDialog = true;
    },
    hideCreateCategoryDialog(state) {
        state.createCategoryDialog = false;
    },
    showEditCategoryDialog(state, data) {
        state.editCategoryDialog = true;
        state.categoryToEdit = data.category;
    },
    hideEditCategoryDialog(state) {
        state.editCategoryDialog = false;
    },
    setCategoryDelete(state, data) {
        state.categoryIdToDelete = data.id;
    },
    endDeleteCategory(state) {
        state.categoryIdToDelete = null;
    },
    // categories mutations:END

    // unit mutation:BEGIN
    showCreateUnitDialog(state) {
        state.createUnitDialog = true;
    },
    hideCreateUnitDialog(state) {
        state.createUnitDialog = false;
    },
    showEditUnitDialog(state, data) {
        state.editUnitDialog = true;
        state.unitToEdit = data.unit;
    },
    hideEditUnitDialog(state) {
        state.editUnitDialog = false;
    },
    setUnitDelete(state, data) {
        state.unitIdToDelete = data.id;
    },
    endDeleteUnit(state) {
        state.unitIdToDelete = null;
    },
    // unit mutation:END

    // articles mutations:BEGIN
    showCreateArticleDialog(state) {
        state.createArticleDialog = true;
    },
    hideCreateArticleDialog(state) {
        state.createArticleDialog = false;
    },
    showEditArticleDialog(state, data) {
        state.editArticleDialog = true;
        state.articleToEdit = data.article;
    },
    hideEditArticleDialog(state) {
        state.editArticleDialog = false;
    },
    setArticleDelete(state, data) {
        state.articleIdToDelete = data.id;
    },
    endDeleteArticle(state) {
        state.articleIdToDelete = null;
    },
    setCurrentPage(state, data) {
        state.currentPage = data.page;
    },
    setSearch(state, data) {
        state.search = data.search;
    },
    // articles mutations:END


    setData(state, data) {
        state.categories = data.categories;
        state.units = data.units;
        state.articles = data.articles.data;
        state.lastPage = data.articles.last_page;
        state.currentPage = data.articles.current_page;
    },
}
export const actions = {
    // categories Actions=======[BEGIN]===========
    storeCategory(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('categories/store', {
                name: payload.name
            }).then(response => {
                // resolve promise
                resolve(response);
                // refetch data 
                context.dispatch('getData');
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true })
            }).catch(error => {
                // reject promise
                reject(error.response);
                console.log(error.response);
            })
        })
    },
    updateCategory(context, payload) {
        return new Promise((resolve, reject) => {
            axios.patch('categories/update', {
                id: payload.id,
                name: payload.name,
            })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // alert 
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('hideEditCategoryDialog');
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    deleteCategory(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('categories/delete', {
                data: {
                    id: context.state.categoryIdToDelete
                }
            })
                .then(response => {
                    // resolve Promise
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('endDeleteCategory');
                })
                .catch(error => {
                    // reject Promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    // categories Actions=======[END]===========

    // units Actions=======[BEGIN]=========
    storeUnit(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('units/store', {
                name: payload.name,
                abr: payload.abr,
                description: payload.description,
            }).then(response => {
                // resolve promise
                resolve(response);
                // refetch data 
                context.dispatch('getData');
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true })
            }).catch(error => {
                // reject promise
                reject(error.response);
            })
        })
    },
    updateUnit(context, payload) {
        return new Promise((resolve, reject) => {
            axios.patch('units/update', {
                id: payload.id,
                name: payload.name,
                abr: payload.abr,
                description: payload.description,
            })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // alert 
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('hideEditUnitDialog');
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    deleteUnit(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('units/delete', {
                data: {
                    id: context.state.unitIdToDelete
                }
            })
                .then(response => {
                    // resolve Promise
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('endDeleteUnit');
                })
                .catch(error => {
                    // reject Promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    // units Actions=======[END  ]=========


    // articles Actions=======[BEGIN]=========
    storeArticle(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('articles/store', {
                name: payload.name,
                category_id: payload.category,
                unit_id: payload.unit,
                notification_quantity: payload.notificationQuantity ? payload.notificationQuantity : 0,
            }).then(response => {
                // resolve promise
                resolve(response);
                // refetch data 
                context.dispatch('getData');
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true })
            }).catch(error => {
                // reject promise
                reject(error.response);
            })
        })
    },
    updateArticle(context, payload) {
        return new Promise((resolve, reject) => {
            axios.patch('articles/update', {
                id: payload.id,
                name: payload.name,
                abr: payload.abr,
                description: payload.description,
            })
                .then(response => {
                    // resolve promise
                    resolve(response);
                    // alert 
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('hideEditArticleDialog');
                })
                .catch(error => {
                    // reject promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    deleteArticle(context, payload) {
        return new Promise((resolve, reject) => {
            axios.delete('articles/delete', {
                data: {
                    id: context.state.articleIdToDelete
                }
            })
                .then(response => {
                    // resolve Promise
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch data 
                    context.dispatch('getData');
                    // hide dialog
                    context.commit('endDeleteArticle');
                })
                .catch(error => {
                    // reject Promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                })
        });
    },
    // articles Actions=======[END  ]=========


    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/articles/index', {
                params: {
                    page: context.state.currentPage,
                    search: context.state.search,
                }
            })
                .then(response => {
                    // resolve Promise
                    resolve(response);
                    // set data
                    context.commit('setData', response.data);
                })
                .catch(error => {
                    // test
                    console.log(error.response);
                })
        });
    }
}
