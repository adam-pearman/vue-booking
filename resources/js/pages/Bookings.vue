<template>
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-medium pb-5">Bookings</h1>
        <div v-if="loading">
            <p>Loading...</p>
        </div>
        <div v-else>
            <div v-if="bookings.length === 0">
                <p>Sorry, there is nothing to book right now!</p>
            </div>
            <div v-else class="grid grid-cols-4 gap-4 w-3/4 mx-auto pb-5">
                <BookingsDetail
                    v-for="booking in bookings"
                    :key="booking.id"
                    :="booking"
                >
                </BookingsDetail>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref} from 'vue';
import BookingsDetail from '../components/bookings/BookingsDetail.vue';

const loading = ref(false);
const bookings = ref([]);

function getBookings() {
    loading.value = true;
    axios.get('/api/v1/bookings')
        .then(response => {
            bookings.value = response.data.data;
            loading.value = false;
        });
}

getBookings();
</script>
