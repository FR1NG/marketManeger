import axios from "axios";

export const state = {
    images: [],
    currentPage: null,
    lastPage: null,
    galeryDialog: false,
};

export const getters = {
    images: state => state.images,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    galeryDialog: state => state.galeryDialog,
};

export const mutations = {
    setImages(state, data) {
        state.images = data.images.data;
        state.currentPage = data.images.current_page;
        state.lastPage = data.images.last_page;
    },
    setCurrentPage(state, data) {
        state.currentPage = data.page;
    },
    showGaleryDialog(state) {
        state.galeryDialog = true;
    },
    hideGaleryDialog(state) {
        state.galeryDialog = false;
    },
};

export const actions = {
    uploadImage(context, payload) {
        return new Promise((resolve, reject) => {
            axios.post('branchements/images/store', payload.formData, {
                ...payload.config
            }).then(response => {
                // resolve
                resolve(response);
                // alert
                context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true })
            }).catch(error => {
                reject(error);
                // alert
                context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true })
            })
        });
    },
    getImages(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('branchements/images/index', {
                params: {
                    page: context.state.page,
                    branchement_id: payload.branchement_id
                }
            }).then(response => {
                // test
                console.log(response);
                // set data 
                context.commit('setImages', response.data);
                // resolve
                resolve(response);
            }).catch(error => {
                // test
                console.log(error.response);

                // reject
                reject(error);
            })
        })
    }
};

