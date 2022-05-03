<template>
<div class="fill-gray-500">
    <IconFullStar v-for="star in fullStars" class="inline w-6 h-6"></IconFullStar>
    <IconHalfStar v-if="halfStar" class="inline w-6 h-6"></IconHalfStar>
    <IconEmptyStar v-for="star in emptyStars" class="inline w-6 h-6"></IconEmptyStar>
</div>
</template>

<script setup>
import {computed} from "vue";
import IconFullStar from '../icons/IconFullStar';
import IconHalfStar from '../icons/IconHalfStar';
import IconEmptyStar from '../icons/IconEmptyStar';

const props = defineProps({
    rating: Number
});

const fraction = Math.round(
    (props.rating - Math.floor(props.rating)) * 100
);

const fullStars = computed(() => {
   return fraction > 0 && fraction < 70 && fraction !== 0 ? Math.ceil(props.rating) - 1 : Math.ceil(props.rating);
});

const halfStar = computed(() => {
    return fraction > 30 && fraction < 70;
});

const emptyStars = computed(() => {
    return fraction > 0 && fraction < 40 ? 6 - Math.ceil(props.rating) : 5 - Math.ceil(props.rating);
})
</script>
