export const state = {
    navigationDrawer : true,
}

export const getters = {
    navigationDrawer : state => state.navigationDrawer,
}

export const mutations = {
    setDrawer(state,value){
        state.navigationDrawer = value;
    },
    toggleDrawer(state){
        state.navigationDrawer = !state.navigationDrawer;
        console.log(state.navigationDrawer);
    }
}