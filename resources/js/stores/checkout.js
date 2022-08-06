import {defineStore} from "pinia";
import {computed, ref} from "vue";


export const useCheckoutStore = defineStore('checkout', () => {
    const basket = ref({
        items: [],
    });

    const itemsInBasket = computed(() => basket.value.items.length);

    function addToBasket(payload) {
        basket.value.items.push(payload);
        localStorage.setItem('basket', JSON.stringify(basket.value));
    }

    function removeFromBasket(payload) {
        basket.value.items = basket.value.items.filter(item => item.booking.id !== payload);
        localStorage.setItem('basket', JSON.stringify(basket.value));
    }

    function inBasketAlready(id) {
        // reduce all values to a single item
        return basket.value.items.reduce(
            (result, item) => result || item.booking.id === id, false
        );
    }

    function loadStoredBasket() {
        const storedBasket = localStorage.getItem('basket');

        if (storedBasket) {
            basket.value = JSON.parse(storedBasket);
        }
    }

    return {basket, itemsInBasket, addToBasket, removeFromBasket, inBasketAlready, loadStoredBasket};
});
