<template>
    <div class="container mx-auto text-center">
        <div v-if="loading">
            <p>Loading...</p>
        </div>
        <div v-else class="grid grid-cols-2 gap-4 w-3/4 mx-auto pb-5">
            <BaseCard>
                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">{{ booking.title }}</h1>
                </div>
                <p>{{ booking.description }}</p>
            </BaseCard>
            <BaseCard>
                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">Prices and Availability</h1>
                </div>
                <p>£{{ booking.price }}</p>
            </BaseCard>
        </div>
    </div>
</template>

<script setup>
import {useRoute} from 'vue-router';
import {ref} from 'vue';
import axios from 'axios';
import BaseCard from '../components/ui/BaseCard.vue';

const route = useRoute();
const bookingId = route.params.id;
const loading = ref(true);
const booking = ref({});

axios.get(`/api/v1/bookings/${bookingId}`)
    .then(response => {
        booking.value = response.data.data;
        loading.value = false;
    });
</script>
