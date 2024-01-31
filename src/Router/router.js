// src/router/router.js
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store/store';

import Referrer from '../../assets/components/ruoli/Referrer.vue';
import Admin from '../../assets/components/ruoli/Admin.vue';
import Tutor from '../../assets/components/ruoli/Tutor.vue';

Vue.use(Router);

const routes = [
    {
        path: '/referrer',
        component: Referrer,
        meta: { requiresAuth: true, requiredRole: 'referrer' },
    },
    {
        path: '/admin',
        component: Admin,
        meta: { requiresAuth: true, requiredRole: 'admin' },
    },
    {
        path: '/tutor',
        component: Tutor,
        meta: { requiresAuth: true, requiredRole: 'tutor' },
    },
];

const router = new Router({
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        //verifico se l'utente è autenticato
        if (!store.state.accessToken) {
            //se non è autenticato rimanda a login
            next('/');
        } else {
            //verifica se ha il ruolo necessario per accedere alla rotta
            const requiredRole = to.meta.requiredRole;
            if (requiredRole && store.state.role !== requiredRole) {
                //altrimenti accesso negato
                next('/unauthorized');
            } else {
                //altrimenti prosegui con la navigazione
                next();
            }
        }
    } else {
        //se la rotta non richiede l'autenticazione vai avanti
        next();
    }
});

export default router;
