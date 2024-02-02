import { createStore } from 'vuex'

export default createStore({
    state: {
        accessToken: null,
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
    actions: {
        retrieveSession() {

        }
    }
});
