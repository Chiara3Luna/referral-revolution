// src/Store/Store.js
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        accessToken: null,
        user: null,
        role: null,
    },
    mutations: {
        setAccessToken(state, token) {
            state.accessToken = token;
            //estrai informazioni dal payload dell'access token
            const payload = parseJwt(token);
            state.user = payload.sub;
            state.role = payload['https://services-metodomerenda.eu.auth0.com/roles'] || null;
        },
        clearAccessToken(state) {
            state.accessToken = null;
            state.user = null;
            state.role = null;
        },
    },
});

//decodifica
function parseJwt(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}