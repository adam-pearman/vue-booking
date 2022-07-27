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
                <ValidationErrors :errors="errorFor('from')"/>
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
                <ValidationErrors :errors="errorFor('to')"/>
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
import {useIsError} from "../../utils/useMethods";
import ValidationErrors from "../ui/ValidationErrors";
import {useBookingStore} from "../../stores/booking";

const props = defineProps({
    bookingId: String
});

const bookingStore = useBookingStore();

const loading = ref(false);
const from = ref(bookingStore.lastSearch.from);
const to = ref(bookingStore.lastSearch.to);
const status = ref(null);
const errors = ref(null);
const hasErrors = computed(() => status.value === 422 && errors.value !== null);
const hasAvailability = computed(() => status.value === 200);
const noAvailability = computed(() => status.value === 404);

function check() {
    loading.value = true;
    errors.value = null;

    bookingStore.setLastSearch({
        from: from.value,
        to: to.value,
    })

    axios.get(`/api/v1/bookings/${props.bookingId}/availability?from=${from.value}&to=${to.value}`)
        .then(response => status.value = response.status)
        .catch(error => {
            if (useIsError(error, 422)) {
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
