<template>
    <nav class="flex flex-auto bg-slate-100 text-black h-12 p-2 border-slate-300 border-b-2 place-items-center font-medium mb-5">
        <router-link :to="{name: 'home'}" class="basis-1/2 opacity-75 text-xl ml-5">Vue Booking</router-link>
        <div class="basis-1/2 text-right space-x-4 text-lg mr-5">
            <router-link v-if="authStore.isLoggedIn" :to="{name: 'basket'}" class="opacity-75 hover:opacity-50 inline-flex items-center gap-1">
                Basket
                <span v-if="checkoutStore.itemsInBasket"
                      class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-500 text-white">
                    {{ checkoutStore.itemsInBasket }}
                </span>
            </router-link>
            <span v-if="authStore.isLoggedIn" @click="logout" class="opacity-75 hover:opacity-50 cursor-pointer">Logout</span>
            <router-link v-if="!authStore.isLoggedIn" :to="{name: 'register'}" class="opacity-75 hover:opacity-50">Register</router-link>
            <router-link v-if="!authStore.isLoggedIn" :to="{name: 'login'}" class="opacity-75 hover:opacity-50">Login</router-link>


        </div>
    </nav>
</template>

<script setup>
import {useCheckoutStore} from "../../stores/checkout";
import {useAuthStore} from "../../stores/auth";
import {useRouter} from "vue-router";

const authStore = useAuthStore();
const checkoutStore = useCheckoutStore();
const router = useRouter();

checkoutStore.loadStoredBasket();

function logout() {
    axios.post('/logout').then(() => {
        authStore.logout()
    })
}
</script>
