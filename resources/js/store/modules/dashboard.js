import axios from "axios";

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
    getData(context, state) {
        return new Promise((resolve, reject) => {
            axios.get('/dashboard/index')
                .then(response => {
                    // resolve
                    resolve(response);
                    // test 
                    console.log(response);
                })
                .catch(error => {
                    // reject
                    reject(error.response);
                    // test
                    console.log(error.response);
                })
        })
    }
};

