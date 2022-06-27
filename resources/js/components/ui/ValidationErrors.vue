<template>
    <div class="text-red-600" v-for="error in errors">
        {{ error }}
    </div>
</template>

<script setup>
const props = defineProps({
    errors: {
        required: true,
    }
})
</script>
