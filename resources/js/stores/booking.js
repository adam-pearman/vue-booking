import {defineStore} from "pinia";
import {ref} from "vue";

export const useBookingStore = defineStore('booking', () => {
    const lastSearch = ref({
        from: null,
        to: null,
    });

    function setLastSearch(payload) {
        lastSearch.value = payload;
        localStorage.setItem('lastSearch', JSON.stringify(payload))
    }

    function loadStoredSearch() {
        const storedSearch = localStorage.getItem('lastSearch');

        if (storedSearch) {
            lastSearch.value = JSON.parse(storedSearch);
        }
    }

    return {lastSearch, setLastSearch, loadStoredSearch};
});
