import api from '../api';

const headers =  {
    "Accept": "application/json"
}

export default {
    namespaced: true,
    state: {
        companies: []
    },
    mutations: {
        setCompanies(state, companies) {
            state.companies = companies;
        }
    },
    actions: {
        async fetchCompanies({ commit }) {
            const response = await api.get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json', null, headers);
            
            console.log(response)
            commit('setCompanies', response);
        }
    },
    getters: {
        companies: state => state.companies
    }
}