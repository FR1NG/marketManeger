export const state = {
    toast: false,
    type: 'info',
    text: '',
};

export const getters = {
    toast: state => state.toast,
    type: state => state.type,
    text: state => state.text,
};

export const mutations = {
    showToast(state, data) {
        state.text = data.text;
        state.type = data.type;
        state.toast = true;
    },
    hideToast(state) {
        state.toast = false;
        state.type = 'info';
        state.text = ''
    }
};

export const actions = {
    show(context, payload) {
        context.commit('showToast', payload);
        setTimeout(() => {
            context.commit('hideToast');
        }, payload.timeOut || 3000);
    }
};

