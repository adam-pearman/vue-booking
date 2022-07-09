<template>
    <div class="container mx-auto">
        <div class="w-full" v-if="success">
            <Success>
                You have left a review!
            </Success>
        </div>
        <div class="w-full" v-if="error">
            <FatalError/>
        </div>
        <div class="w-full flex" v-if="!success && !error">
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
                        <StarRating v-if="ratingCheck" v-model:rating="review.rating" :size="48" class="mb-6"/>
                        <label for="content" class="mb-2">Describe your experience with {{reservation.booking.title}}</label>
                        <textarea name="content"
                                  id="content"
                                  cols="30"
                                  rows="10"
                                  class="rounded-lg"
                                  v-model="review.content"
                                  :class="{'border-red-600': errorFor('content')}"
                        ></textarea>
                        <ValidationErrors :errors="errorFor('content')"/>
                        <button type="submit"
                                class="px-4 py-2 mt-6 border border-gray-500 shadow-sm text-base
                                font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 focus:outline-none
                                focus:ring-2 focus:ring-indigo-500"
                                :disabled="sending">
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
import {useIsError} from "../utils/useMethods";
import FatalError from "../components/ui/FatalError";
import ValidationErrors from "../components/ui/ValidationErrors";
import _ from "lodash";
import Success from "../components/ui/Success";

const route = useRoute();
const existingReview = ref(null);
const reservation = ref(null);
const loading = ref(false);
const error = ref(false);
const errors = ref(null);
const sending = ref(false);
const success = ref(false);

const review = ref({
    id: null,
    rating: 5,
    content: null
})

const alreadyReviewed = computed(() => hasReview.value || !hasReservation.value);
const hasReview = computed(() => existingReview.value !== null);
const hasReservation = computed(() => reservation.value !== null);
const oneColumn = computed(() => !loading.value && alreadyReviewed.value);
const twoColumns = computed(() => loading.value || !alreadyReviewed.value);
const ratingCheck = computed(() => review.value.rating > 0 && review.value.rating < 6);

async function checkReview() {
    review.value.id = route.params.id;
    loading.value = true;

    try {
        existingReview.value = (await axios.get(`/api/v1/reviews/${review.value.id}`)).data.data;
    } catch (err) {
        if (useIsError(err, 404)) {
            try {
                reservation.value = (await (axios.get(`/api/v1/reservation-by-review/${review.value.id}`))).data.data;
            } catch (err) {
                error.value = !useIsError(err, 404);
            }
        } else {
            error.value = true;
        }
    }
    loading.value = false;
}

function submit() {
    errors.value = null;
    sending.value = true;
    axios.post(`/api/v1/reviews`, review.value)
        .then(response => success.value = response.status === 201)
        .catch(err => {
            if (useIsError(err, 422)) {
                const errs = err.response.data.errors;
                if (errs['content'] && _.size(errs) === 1) {
                    errors.value = errs;
                    return;
                }
            }
            error.value = true;
        })
        .then(() => {
            return sending.value = false
        });
}

function errorFor(field) {
    return errors.value !== null && errors.value[field] ? errors.value[field] : null;
}

checkReview();
</script>
