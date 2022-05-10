<template>
<div class="fill-gray-500">
    <IconFullStar v-for="star in fullStars"
                  :class="'inline w-' + props.size + ' h-auto'"
                  @click="$emit('update:rating', star)"
    />
    <IconHalfStar v-if="halfStar"
                  :class="'inline w-' + props.size + ' h-auto'"
    />
    <IconEmptyStar v-for="star in emptyStars"
                   :class="'inline w-' + props.size + ' h-auto'"
                   @click="$emit('update:rating', fullStars + star)"
    />
</div>
</template>

<script setup>
import {computed} from "vue";
import IconFullStar from '../icons/IconFullStar';
import IconHalfStar from '../icons/IconHalfStar';
import IconEmptyStar from '../icons/IconEmptyStar';

const props = defineProps({
    rating: Number,
    size: Number
});

const emit = defineEmits([
    'update:rating'
]);

const fraction = Math.round(
    (props.rating - Math.floor(props.rating)) * 100
);

const fullStars = computed(() => {
   return fraction > 0 && fraction < 80 && fraction !== 0 ? Math.ceil(props.rating) - 1 : Math.ceil(props.rating);
});

const halfStar = computed(() => {
    return fraction > 20 && fraction < 80;
});

const emptyStars = computed(() => {
    return fraction > 0 && fraction < 30 ? 6 - Math.ceil(props.rating) : 5 - Math.ceil(props.rating);
})
</script>
