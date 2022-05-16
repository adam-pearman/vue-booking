<template>
    <div class="px-4">
        <h3 class="text-xl font-medium pb-2 border-b border-gray-400">Reviews</h3>
        <div v-if="loading" class="py-2">
            <p>Loading...</p>
        </div>
        <div v-else-if="false" class="py-2">
            <p>This booking has no reviews yet.</p>
        </div>
        <div v-else>
            <div class="grid grid-cols-2 border-b border-gray-400 py-2"
                 v-for="(review, index) in reviews"
                 :key="index"
            >
                <p class="font-medium">Anonymous</p>
                <div class="justify-self-end">
                    <StarRating :rating="parseFloat(review.rating)" :size="32"></StarRating>
                </div>

                <p class="italic">{{ commentTime(review.created_at) }} ago</p>
                <p class="col-span-2 mt-5">{{ review.content }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {formatDistanceToNowStrict} from "date-fns"
import StarRating from "../ui/StarRating";

const props = defineProps({
    bookingId: String
});

const loading = ref(false);
const reviews = ref([]);

function commentTime(created_at) {
    return formatDistanceToNowStrict(new Date(created_at));
}

function getReviews() {
    loading.value = true;
    axios.get(`/api/v1/bookings/${props.bookingId}/reviews`)
        .then(response => {
            reviews.value = response.data.data;
            loading.value = false;
        });
}

getReviews();
</script>
