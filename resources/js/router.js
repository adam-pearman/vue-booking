import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        path: '/',
        component: () => import('./pages/Home'),
        name: 'home'
    },
    {
        path: '/contact',
        component: () => import('./pages/Contact'),
        name: 'contact'
    },
    {
        path: '/bookings',
        component: () => import('./pages/Bookings'),
        name: 'bookings'
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
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
