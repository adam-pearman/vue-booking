<template>
    <div class="text-center text-gray-500">
        <ThumbIcon class="mx-auto py-10 w-1/12 fill-gray-500"/>
        <h1 class="text-2xl">Success!</h1>
        <h2 class="text-xl"><slot/></h2>
    </div>
</template>

<script setup>
import ThumbIcon from '../icons/ThumbIcon'
</script>
