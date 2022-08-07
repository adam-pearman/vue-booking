import {createRouter, createWebHistory} from "vue-router";
import {hasStorageLogin} from "./utils/useAuthHelpers";

const routes = [
    {
        path: '/',
        component: () => import('./pages/Bookings'),
        name: 'home'
    },
    {
        path: '/bookings/:id',
        component: () => import('./pages/Booking'),
        name: 'booking'
    },
    {
        path: '/review/:id',
        component: () => import('./pages/Review'),
        name: 'review'
    },
    {
        path: '/basket',
        component: () => import('./pages/Basket'),
        name: 'basket',
        meta: { requiresAuth: true },
    },
    {
        path: '/login',
        component: () => import('./pages/Auth/LoginPage'),
        name: 'login'
    },
    {
        path: '/register',
        component: () => import('./pages/Auth/RegistrationPage'),
        name: 'register'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to) => {
    if (to.name === 'login' && hasStorageLogin()) {
        return {
            path: '/'
        }
    }

    if (to.name === 'register' && hasStorageLogin()) {
        return {
            path: '/'
        }
    }

    if (to.meta.requiresAuth && !hasStorageLogin()) {
        return {
            path: '/'
        }
    }
})

export default router;
