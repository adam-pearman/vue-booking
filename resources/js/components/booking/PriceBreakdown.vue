<template>
    <div>
        <h3 class="text-xl leading-6 font-medium text-gray-900 pb-4">
            Price Breakdown
        </h3>
        <div v-for="(days, price) in price.breakdown" :key="price" class="py-2 border-y border-gray-500 flex justify-between">
            <span>{{days}} days at £{{price}}</span>
            <span>£{{days * price}}</span>
        </div>
        <div class="font-medium pt-4 flex justify-between">
            <span>Total</span>
            <span>£{{price.total}}</span>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        price: {
            type: [Object, null],
            required: true,
        }
    })
</script>
