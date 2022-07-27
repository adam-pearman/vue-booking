<template>
    <div class="container mx-auto">
        <div v-if="loading" class="text-center">
            <p>Loading...</p>
        </div>
        <div v-else class="grid xl:grid-cols-3 gap-10 w-3/4 mx-auto">
            <BaseCard class="col-span-2">
                <div class="bg-white pb-4 mb-4 border-b border-gray-200">
                    <h1 class="text-xl font-medium text-gray-900">{{ booking.title }}</h1>
                </div>
                <p>{{ booking.description }}</p>
            </BaseCard>
            <div class="col-span-2 xl:col-span-1">
                <availability :booking-id="bookingId" @availability="checkPrice"></availability>
                    <Transition enter-active-class="transition-opacity duration-500"
                                enter-from-class="opacity-0"
                                leave-active-class="transition-opacity duration-0"
                                leave-to-class="opacity-0">
                        <div class="grid grid-cols-2 gap-4 px-4 mt-4" v-if="price">
                            <PriceBreakdown class="col-span-2" :price="price"/>
                            <button type="submit"
                                    class="col-span-2 px-4 py-2 border border-gray-500 shadow-sm text-base
                                font-medium rounded-md text-gray-500 300 hover:bg-gray-500 hover:text-white focus:outline-none focus:ring-2
                                focus:ring-indigo-500">
                                Book Now
                            </button>
                        </div>
                    </Transition>
            </div>
            <div class="col-span-2">
                <ReviewList :booking-id="bookingId"></ReviewList>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useRoute} from 'vue-router';
import {ref} from 'vue';
import axios from 'axios';
import BaseCard from '../components/ui/BaseCard';
import Availability from "../components/booking/Availability";
import ReviewList from "../components/booking/ReviewList";
import {useBookingStore} from "../stores/booking";
import PriceBreakdown from '../components/booking/PriceBreakdown';

const bookingStore = useBookingStore();

const route = useRoute();
const bookingId = route.params.id ;
const loading = ref(false);
const booking = ref({});
const price = ref(null);

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

bookingStore.loadStoredSearch();
getBooking();
</script>
