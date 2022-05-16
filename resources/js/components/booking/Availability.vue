<template>
    <div class="text-left p-4">
        <h1 class="text-xl leading-6 font-medium text-gray-900 pb-3">
            Check Availability
            <span v-if="noAvailability" class="text-red-600">
                - NOT AVAILABLE
            </span>
            <span v-if="hasAvailability" class="text-green-600">
                - AVAILABLE
            </span>
        </h1>
        <form @submit.prevent="check" class="grid grid-cols-2 gap-4">
            <div>
                <label for="from" class="block">From</label>
                <input
                    type="date"
                    name="from"
                    id="from"
                    class="rounded w-full"
                    v-model="from"
                    :class="{'border-red-600': errorFor('from')}"
                >
                <div class="text-red-600" v-for="error in errorFor('from')">
                    {{ error }}
                </div>
            </div>
            <div>
                <label for="to" class="block">To</label>
                <input
                    type="date"
                    name="to"
                    id="to"
                    class="rounded w-full"
                    v-model="to"
                    :class="{'border-red-600': errorFor('to')}"
                >
                <div class="text-red-600" v-for="error in errorFor('to')">
                    {{ error }}
                </div>
            </div>
            <button type="submit"
                    class="col-span-2 px-4 py-2 border border-gray-500 shadow-sm text-base
                font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2
                focus:ring-indigo-500">
                Check
            </button>
        </form>
    </div>
</template>

<script setup>
import {ref, computed} from "vue";

const props = defineProps({
    bookingId: String
});

const loading = ref(false);
const from = ref('');
const to = ref('');
const status = ref(null);
const errors = ref(null);
const hasErrors = computed(() => status.value === 422 && errors.value !== null);
const hasAvailability = computed(() => status.value === 200);
const noAvailability = computed(() => status.value === 404);

function check() {
    loading.value = true;
    errors.value = null;

    axios.get(`/api/v1/bookings/${props.bookingId}/availability?from=${from.value}&to=${to.value}`)
        .then(response => status.value = response.status)
        .catch(error => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
            status.value = error.response.status;
        })
        .then(() => loading.value = false);
}

function errorFor(field) {
    return hasErrors.value && errors.value[field] ? errors.value[field] : null;
}
</script>