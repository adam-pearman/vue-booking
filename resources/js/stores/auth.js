import {defineStore} from "pinia";
import {ref} from "vue";
import {hasStorageLogin, storageLogout} from "../utils/useAuthHelpers";

export const useAuthStore = defineStore('auth', () => {
    const user = ref({});
    const isLoggedIn = ref(false);

    function getAuthUser() {
        if (hasStorageLogin()) {
            axios.get('/api/user').then((response) => {
                user.value = response.data;
                isLoggedIn.value = true;
            }).catch(() => {
                logout();
            });
        }
    }

    function logout() {
        user.value = {};
        isLoggedIn.value = false;
        storageLogout();
    }

    return {user, isLoggedIn, getAuthUser, logout}
})
