require('./bootstrap');

import {createApp} from 'vue';
import {createPinia} from "pinia";
import App from './App.vue';
import router from './router';
import {useAuthStore} from "./stores/auth";

window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response.status === 401) {
            const authStore = useAuthStore();
            authStore.logout();
        }
        return Promise.reject(error);
    }
)
createApp(App)
    .use(router)
    .use(createPinia())
    .mount('#app');
