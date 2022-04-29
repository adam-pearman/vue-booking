import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        path: '/',
        component: () => import('./pages/Home.vue'),
        name: 'home'
    },
    {
        path: '/contact',
        component: () => import('./pages/Contact.vue'),
        name: 'contact'
    },
    {
        path: '/bookings',
        component: () => import('./pages/Bookings.vue'),
        name: 'bookings'
    },
    {
        path: '/bookings/:id',
        component: () => import('./pages/Booking.vue'),
        name: 'booking'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
