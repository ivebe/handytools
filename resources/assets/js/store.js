import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        identitiles_value: '',
        identitiles_md5: ''
    },
    mutations: {
        updateIdentitiles(state, newValue){
            state.identitiles_value = newValue
        },
        updateIdentitilesMD5(state, newValue){
            state.identitiles_md5 = newValue
        }
    }
})
