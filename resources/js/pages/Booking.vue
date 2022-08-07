<template>
    <div class="container mx-auto">
        <div v-if="loading" class="text-center">
            <p>Loading...</p>
        </div>
        <div v-else class="flex flex-col gap-4 w-full mx-auto lg:gap-10 lg:flex-row">
            <div class="flex flex-col gap-4 lg:gap-10 lg:w-2/3">
                <BaseCard class="mx-4">
                    <div class="bg-white pb-4 mb-4 border-b border-gray-200">
                        <h1 class="text-xl font-medium text-gray-900">{{ booking.title }}</h1>
                    </div>
                    <p>{{ booking.description }}</p>
                </BaseCard>
                <ReviewList :booking-id="bookingId" class="hidden lg:block"></ReviewList>
            </div>
            <div class="lg:w-1/3">
                <availability :booking-id="bookingId" @availability="checkPrice"></availability>
                <Transition enter-active-class="transition-opacity duration-500"
                            enter-from-class="opacity-0"
                            leave-active-class="transition-opacity duration-0"
                            leave-to-class="opacity-0">
                    <div class="grid grid-cols-2 gap-4 px-4 mt-4" v-if="price">
                        <PriceBreakdown class="col-span-2" :price="price"/>
                        <button @click="addToBasket"
                                :disabled="inBasketAlready || !authStore.isLoggedIn"
                                type="submit"
                                class="col-span-2 px-4 py-2 mb-4 border border-gray-500 shadow-sm text-base
                            font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2
                            focus:ring-indigo-500 disabled:bg-gray-300 disabled:text-gray-500">
                            Book Now
                        </button>
                        <div v-if="!authStore.isLoggedIn" class="col-span-2 text-xs text-gray-500">
                            Please register or login to make a reservation.
                        </div>
                    </div>
                </Transition>
                <div v-if="authStore.isLoggedIn" class="grid grid-cols-2 gap-4 px-4">
                    <button @click="removeFromBasket"
                            v-if="inBasketAlready"
                            type="submit"
                            class="col-span-2 px-4 py-2 border border-gray-500 shadow-sm text-base
                            font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2
                            focus:ring-indigo-500">
                        Remove From Basket
                    </button>
                    <div v-if="inBasketAlready" class="col-span-2 text-xs text-gray-500">
                        It looks like this item is already in your basket. If you'd like to amend your dates,
                        please first remove this item from your basket.
                    </div>
                </div>
            </div>
            <ReviewList :booking-id="bookingId" class="lg:hidden"></ReviewList>
        </div>
    </div>
</template>

<script setup>
import {useRoute} from 'vue-router';
import {computed, ref} from 'vue';
import axios from 'axios';
import BaseCard from '../components/ui/BaseCard';
import Availability from "../components/booking/Availability";
import ReviewList from "../components/booking/ReviewList";
import {useBookingStore} from "../stores/booking";
import PriceBreakdown from '../components/booking/PriceBreakdown';
import {useCheckoutStore} from "../stores/checkout";
import {useAuthStore} from "../stores/auth";

const authStore = useAuthStore();
const bookingStore = useBookingStore();
const checkoutStore = useCheckoutStore();

const route = useRoute();
const bookingId = route.params.id ;
const loading = ref(false);
const booking = ref({});
const price = ref(null);

const inBasketAlready = computed(() => {
    if (booking.value === null) {
        return false;
    }

    return checkoutStore.inBasketAlready(booking.value.id)
})

function getBooking() {
    loading.value = true;
    axios.get(`/api/v1/bookings/${bookingId}`)
        .then(response => {
            booking.value = response.data.data;
            loading.value = false;
        });
}

function checkPrice(hasAvailability) {
    if (!hasAvailability) {
        price.value = null;
    } else {
        axios.get(`/api/v1/bookings/${bookingId}/price?from=${bookingStore.lastSearch.from}&to=${bookingStore.lastSearch.to}`)
            .then(response => {
                price.value = response.data.data;
            })
            .catch(() => {
                price.value = null;
            })
    }
}

function addToBasket() {
    checkoutStore.addToBasket({
        booking: booking.value,
        price: price.value,
        dates: bookingStore.lastSearch,
    });
}

function removeFromBasket() {
    checkoutStore.removeFromBasket(booking.value.id);
}

bookingStore.loadStoredSearch();
getBooking();
</script>
