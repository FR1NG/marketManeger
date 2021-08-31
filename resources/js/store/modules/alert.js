export const state = {
    type : '',
    text : '',
    alert : false,
};

export const getters = {
    type : state => state.type,
    text : state => state.text,
    alert : state => state.alert
}

export const mutations = {
   
}

export const actions = {
    show(context,params){
        params.text ? context.state.text = params.text : context.state.text = '';
        params.type ? context.state.type = params.type : context.state.type = '';
        context.state.alert = true;
        setTimeout(function(){
            context.dispatch('hide');
        },3000);
    },
    hide(context){
        context.state.alert = false;
        context.state.text = '';
        context.state.type = '';
    }
}