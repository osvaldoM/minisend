import Vue from "vue";
import VueRouter from 'vue-router'
import Toasted from "vue-toasted";


Vue.use(VueRouter);
Vue.use(Toasted, {
    router: VueRouter
});

Vue.toasted.register('save_error', (payload) => {
    if(payload.message){
        return payload.message;
    }
    if(payload.entity){
        return `error saving ${payload.entity}`;
    }
    return 'Oops.. Something Went Wrong..';
}, {
    type: 'error',
    duration: 8000
});

Vue.toasted.register('load_error', (payload) => {
    if(payload.message){
        return payload.message;
    }
    if(payload.entity){
        return `error loading ${payload.entity}`;
    }
    return 'Oops.. Something Went Wrong..';
}, {
    type: 'error',
    duration: 8000
});

Vue.toasted.register('save_success', (payload) => {
    if(payload.entity){
        return `${payload.entity} created`;
    }
    return 'Saved !';
}, {
    type: 'success',
    duration: 8000
});
