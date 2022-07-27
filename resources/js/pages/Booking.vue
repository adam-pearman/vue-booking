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
                <availability :booking-id="bookingId"></availability>
                <p class="text-center">£{{ booking.price }}</p>
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

const bookingStore = useBookingStore();

const route = useRoute();
const bookingId = route.params.id ;
const loading = ref(false);
const booking = ref({});

function getBooking() {
    loading.value = true;
    axios.get(`/api/v1/bookings/${bookingId}`)
        .then(response => {
            booking.value = response.data.data;
            loading.value = false;
        });
}

bookingStore.loadStoredSearch();
getBooking();
</script>
