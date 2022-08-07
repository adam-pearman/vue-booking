import {defineStore} from "pinia";
import {ref, computed} from "vue";

export const useAuthStore = defineStore('auth', () => {
    const user = ref({});
    const isLoggedIn = computed(() => Object.keys(user.value).length !== 0);

    function getAuthUser() {
        axios.get('/api/user').then((response) => {
            user.value = response.data;
        }).catch(() => {
            user.value = {};
        })
    }

    return {user, isLoggedIn, getAuthUser}
})
