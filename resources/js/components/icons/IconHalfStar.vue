<template>
    <svg xmlns="http://www.w3.org/2000/svg" :height="props.size" :width="props.size" viewBox="0 0 48 48">
        <path d="M24 14.45V30.65L30.85 35.85L28.1 27.2L34.4 23.1H26.85ZM11.65 44 16.3 28.8 4 20H19.2L24 4L28.8
        20H44L31.7 28.8L36.35 44L24 34.6Z"/>
    </svg>
</template>

<script setup>
const props = defineProps({
    size: Number,
});
</script>
