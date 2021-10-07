import axios from "axios";

export const state = {
    loading: false,
    statistics: [],
    incom: null,
    branchements_count: null,
    weekBranchements: [],
    byMarket: [],
};

export const getters = {
    loading: state => state.loading,
    statistics: state => state.statistics,
    incom: state => state.incom,
    branchements_count: state => state.branchements_count,
    weekBranchements: state => {
        let labels = [];
        let data = [];
        for (const [key, value] of Object.entries(state.weekBranchements)) {
            labels.push(key)
            data.push(value);
        }

        return { labels, data };
    },
    byMarket: state => {
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        let labels = [];
        let data = [];
        let backgroundColors = [];

        state.byMarket.forEach(element => {
            labels.push(element.name);
            data.push(element.branchements_count);
            backgroundColors.push(getRandomColor());
        });
        return { labels, data, backgroundColors }
    },
};

export const mutations = {
    setData(state, data) {
        console.log(data);
        state.statistics = data;
        state.incom = data.incom;
        state.branchements_count = data.branchements_count;
        state.weekBranchements = data.weekBranchements;
        state.byMarket = data.byMarket;
    }
};

export const actions = {
    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('admin/dashboard')
                .then(response => {
                    // resolve
                    resolve(response);
                    // loading false
                    context.state.loading = false;
                    // set data 
                    context.commit('setData', response.data);
                })
                .catch(error => {
                    // reject 
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });
                });
        });
    }
};

