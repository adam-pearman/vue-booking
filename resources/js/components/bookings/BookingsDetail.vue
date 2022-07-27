<template>
    <router-link :to="{name: 'booking', params: {id}}" class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <p class="font-medium text-lg">{{ title }}</p>
            <p>{{ description }}</p>
            <br>
            <p class="font-medium">£{{ price }}</p>
        </div>
    </router-link>
</template>

<script setup>
const props = defineProps({
    id: Number,
    title: String,
    description: String,
    price: Number,
});
</script>
