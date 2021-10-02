import axios from "axios";

export const state = {
    details: {
        achat: {},
    },
    detailsLoading: false,
};

export const getters = {
    details: state => state.details,
    detailsLoading: state => state.detailsLoading,
};

export const mutations = {
    setDetailsData(state, data) {
        state.details = data.livraison;
        console.log(data.livraison);
    },
    resetDetails(state) {
        state.details = {
            achat: {},
        };
    }

};

export const actions = {
    store(context, payload) {
        const form = payload.form;
        return new Promise((resolve, reject) => {
            axios.post('livraisons/store', {
                achat_id: form.achat_id,
                dilevery_note_number: form.deliveryNoteNumber,
                date: form.date,
                delivery_man: form.deliveryMan,
                delivery_cost: form.deliveryCost,
                items: payload.items
            })
                .then(response => {
                    // test
                    console.log(response);
                    // resolve promise
                    resolve(response);
                    // alert
                    context.dispatch('alert/show', { text: response.data.message, type: 'success' }, { root: true });
                    // refetch achat data
                    context.dispatch('achat/getAchatDetails', { id: form.achat_id }, { root: true });

                })
                .catch(error => {
                    // test
                    console.log(error.response);
                    // reject promise
                    reject(error.response);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        });
    },
    getLivraisonDetails(context, payload) {
        context.state.detailsLoading = true;
        return new Promise((resolve, reject) => {
            axios.get('livraisons/details', {
                params: {
                    id: payload.id,
                }
            })
                .then(response => {
                    // stoo loading
                    context.state.detailsLoading = false;
                    // resolve
                    resolve(response);
                    // set data
                    context.commit('setDetailsData', response.data);
                })
                .catch(error => {
                    // reject
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        });
    }
};

