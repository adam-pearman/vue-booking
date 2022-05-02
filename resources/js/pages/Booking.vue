<template>
    <div class="container mx-auto text-center">
        <div v-if="loading">
            <p>Loading...</p>
        </div>
        <div v-else class="grid grid-cols-3 gap-10 w-3/4 mx-auto pb-5">
            <BaseCard class="col-span-2 text-left">
                <div class="bg-white pb-2 mb-2 border-b border-gray-200">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">{{ booking.title }}</h1>
                </div>
                <p>{{ booking.description }}</p>
            </BaseCard>
            <div>
                <availability></availability>
                <p>£{{ booking.price }}</p>
            </div>

        </div>
    </div>
</template>

<script setup>
import {useRoute} from 'vue-router';
import {ref} from 'vue';
import axios from 'axios';
import BaseCard from '../components/ui/BaseCard.vue';
import Availability from "../components/booking/Availability";

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
