import axios from "axios";

const initialState = () => {
    return {
        statistics: {
            cities: [],
            weekBranchements: [],
            accomplishement: [],
        },
        articles: [],
        // accomplishment: [],
        branchementType: null,
    }
};
export const state = initialState;

export const getters = {
    statistics: state => state.statistics,
    articles: state => state.articles,
    branchementType: state => state.branchementType,
    // accomplishment: state => state.accomplishment,
    accomplishement: state => state.statistics.accomplishement,
    weekBranchements: state => {
        let labels = [];
        let data = [];
        for (const [key, value] of Object.entries(state.statistics.weekBranchements)) {
            labels.push(key)
            data.push(value);
        }

        return { labels, data };
    },
    byCities: state => {
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
        state.statistics.cities.forEach(element => {
            labels.push(element.name);
            data.push(element.branchements_count);
            backgroundColors.push(getRandomColor());
        });
        return { labels, data, backgroundColors }
    }
};

export const mutations = {
    setData(state, data) {
        state.statistics = data;
        state.articles = data.articles;
    },
    setBranchementType(state, type) {
        state.branchementType = type;
    },
    resetState(state) {
        Object.assign(state, initialState())
    }
};

export const actions = {
    getData(context, state) {
        console.log(context.state.branchementType);
        return new Promise((resolve, reject) => {
            axios.get('/dashboard/index', {
                params: {
                    type: context.state.branchementType,
                }
            })
                .then(response => {
                    // resolve
                    resolve(response);
                    // set data
                    context.commit('setData', response.data);
                })
                .catch(error => {
                    // reject
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        })
    },
    getAccomlishment(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/dashboard/getAccomlishment', {
                params: {
                    id: payload.id
                }
            })
                .then(response => {
                    resolve(response);
                    // set data

                })
                .catch(error => {
                    // reject
                    reject(error);
                    // test
                    console.log(error.response)

                })
        })
    }
};

