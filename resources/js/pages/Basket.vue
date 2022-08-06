<template>
    <div class="flex w-full container mx-auto">
        <div class="w-2/3">Checkout Form</div>
        <div class="w-1/3">
            <div class="flex justify-between">
                <h3 class="font-medium text-2xl">Your Cart</h3>
                <span class="inline-flex items-center px-3 py-0.5 rounded-md text-sm font-medium bg-gray-500 text-white mb-4">
                    <span v-if="checkoutStore.itemsInBasket">
                        {{ checkoutStore.itemsInBasket }}
                    </span>
                    <span v-else>
                        Empty
                    </span>
                </span>
            </div>
            <div v-for="item in checkoutStore.basket.items" :key="item.booking.id">
                <div class="py-2 flex border border-t-gray-500 justify-between font-medium">
                    <span class="hover:opacity-50">
                        <router-link :to="{name: 'booking', params: {id: item.booking.id}}">{{ item.booking.title }}</router-link>
                    </span>
                    <span>
                        £{{ item.price.total }}
                    </span>
                </div>
                <div class="py-2 flex justify-between">
                    <span>
                        From: {{ format(new Date(item.dates.from), 'dd/MM/yyyy') }}
                    </span>
                    <span>
                        To: {{ format(new Date(item.dates.to), 'dd/MM/yyyy') }}
                    </span>
                </div>
                <div class="w-full flex justify-end">
                    <div class="group p-1 w-8 h-8 mb-2 border border-gray-500 rounded-md flex place-content-center cursor-pointer hover:bg-gray-500"
                         @click="checkoutStore.removeFromBasket(item.booking.id)">
                        <TrashIcon class="fill-gray-500 group-hover:fill-white"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useCheckoutStore} from "../stores/checkout";
import {format} from "date-fns";
import TrashIcon from '../components/icons/TrashIcon'

const checkoutStore = useCheckoutStore();
</script>
