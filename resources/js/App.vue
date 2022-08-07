<template>
    <TheNav></TheNav>
    <router-view></router-view>
</template>

<script setup>
import TheNav from './components/ui/TheNav.vue';
import {useAuthStore} from "./stores/auth";

const authStore = useAuthStore();

authStore.getAuthUser();
</script>
