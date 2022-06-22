<template>
    <div class="container mx-auto">
        <div class="w-full" v-if="error">
            <FatalError/>
        </div>
        <div class="w-full flex" v-else>
            <div class="flex flex-col"
                 :class="[{'md:w-4/12' : twoColumns},
                  {'hidden' : oneColumn}]">
                <BaseCard>
                    <div v-if="loading">
                        Loading...
                    </div>
                    <div v-if="hasReservation">
                        <p>
                            Stayed at
                            <router-link :to="{name: 'booking', params: {id: reservation.booking.id}}"
                                         class="text-blue-600 hover:text-blue-800">
                                {{reservation.booking.title}}
                            </router-link>
                        </p>
                        <br>
                        <p>From {{reservation.from}} to {{reservation.to}}</p>
                    </div>
                </BaseCard>
            </div>
            <div class="flex flex-col"
                 :class="[{'md:w-8/12' : twoColumns},
                  {'md:w-full' : oneColumn}]">
                <div v-if="loading">
                    <h3 class="text-center">Loading...</h3>
                </div>
                <div v-else-if="alreadyReviewed">
                    <h3 class="text-center">You've already left a review for this booking.</h3>
                </div>
                <div v-else>
                    <form @submit.prevent="submit" class="grid grid-cols-1 place-content-center w-3/4 mx-auto">
                        <label class="mb-2">Select the star rating (1 is worst - 5 is best)</label>
                        <StarRating v-model:rating="review.rating" :size="48" class="mb-6"/>
                        <label for="content" class="mb-2">Describe your experience with {{reservation.booking.title}}</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="mb-6 rounded-lg" v-model="review.content"></textarea>
                        <button type="submit"
                                class="px-4 py-2 border border-gray-500 shadow-sm text-base
                                font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 focus:outline-none
                                focus:ring-2 focus:ring-indigo-500">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import StarRating from '../components/ui/StarRating';
import {computed, ref} from "vue";
import {useRoute} from "vue-router";
import BaseCard from "../components/ui/BaseCard";
import {is404} from "../utils/response";
import FatalError from "../components/ui/FatalError";

const route = useRoute();
const existingReview = ref(null);
const reservation = ref(null);
const loading = ref(false);
const error = ref(false);

const review = ref({
    id: null,
    rating: 5,
    content: null
})

const alreadyReviewed = computed(() => {
    return hasReview.value || !hasReservation.value;
});
const hasReview = computed(() => {
    return existingReview.value !== null;
});
const hasReservation = computed(() => {
    return reservation.value !== null;
})
const oneColumn = computed(() => {
    return !loading.value && alreadyReviewed.value;
})
const twoColumns = computed(() => {
    return loading.value || !alreadyReviewed.value;
})

function checkReview() {
    review.value.id = route.params.id;
    loading.value = true;
    axios.get(`/api/v1/reviews/${review.value.id}`)
        .then(response => {
            existingReview.value = response.data.data
        })
        .catch(err => {
            if (is404(err)) {
                return axios.get(`/api/v1/reservation-by-review/${review.value.id}`)
                    .then(response => {
                        reservation.value = response.data.data;
                    })
                    .catch(err => {
                        error.value = !is404(err);
                    });
            }
        })
        .then(() => loading.value = false);
}

function submit() {
    loading.value = true;
    axios.post(`/api/v1/reviews`, review.value)
        .then(response => console.log(response))
        .catch(err => error.value = true)
        .then(() => loading.value = false);
}

checkReview();
</script>
