<template>
    <div class="container mx-auto">
        <h1 class="text-4xl font-medium pb-5 text-center">Review</h1>
        <form @submit.prevent="testFunc" class="grid grid-cols-1 place-content-center w-3/4 mx-auto">
            <label class="mb-2">Select the star rating (1 is worst - 5 is best)</label>
            <StarRating v-model:rating="rating" :size="48" class="mb-6"/>
            <label for="content" class="mb-2">Describe your experience with</label>
            <textarea name="content" id="content" cols="30" rows="10" class="mb-6" v-model="content"></textarea>
            <button type="submit"
                    class="px-4 py-2 border border-gray-500 shadow-sm text-base
            font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2
            focus:ring-indigo-500">
                Submit
            </button>
        </form>
    </div>
</template>

<script setup>
import StarRating from '../components/ui/StarRating';
import {computed, ref} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();
const reviewId = route.params.id;
const existingReview = ref(null);
const rating = ref(5);
const content = ref('');

const alreadyReviewed = computed(() => {
    return existingReview.value !== null;
})

function checkReview() {
    axios.get(`api/v1/reviews/${reviewId}`)
        .then(response => existingReview.value = response.data.data)
        .catch(error => {
        //
        });
}

function testFunc() {
    console.log(rating.value);
    console.log(content.value);
}

checkReview();
</script>
