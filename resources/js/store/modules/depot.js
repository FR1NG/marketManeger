export const state = {
    items: [],
    currentPage: null,
    lastPage: null,
    search: null,
};

export const getters = {
    items: state => state.items,
    currentPage: state => state.currentPage,
    lastPage: state => state.lastPage,
    search: state => state.search,
};

export const mutations = {
    setData(state, data) {
        state.items = data.items;
        state.currentPage = data.current_page;
        state.currentPage = data.last_page;
    },
    setCurrentPage(state, { page }) {
        state.currentPage = page
    },
    setSearch(state, { search }) {
        state.search = search;
    }
};

export const actions = {
    getData(context, payload) {
        return new Promise((resolve, reject) => {
            axios.get('warehouses/index', {
                params: {
                    page: context.state.currentPage,
                    search: context.state.search
                }
            })
                .then(response => {
                    // test
                    console.log(response);
                    // resolve
                    resolve(response);
                    // set data 
                    context.commit('setData', response.data);

                })
                .catch(error => {
                    // test 
                    console.log(error.response)
                    // reject
                    reject(error);
                    // alert
                    context.dispatch('alert/show', { text: error.response.data.message, type: 'error' }, { root: true });

                })
        });
    }
};

