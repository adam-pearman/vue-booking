<template>
    <router-link :to="{name: 'booking', params: {id}}" class="bg-white h-full overflow-hidden shadow rounded-lg">
        <div class="flex flex-col h-full px-4 py-5 sm:p-6">
            <div class="h-full">
                <p class="font-medium text-lg mb-2">{{ title }}</p>
                <p>{{ description }}</p>
            </div>
            <p class="font-medium mt-6">£{{ price }}</p>
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
