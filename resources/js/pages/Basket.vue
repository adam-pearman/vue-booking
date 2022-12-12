<template>
    <div>
        <div class="w-full" v-if="success">
            <Success> Congratulations on your purchase! </Success>
        </div>
        <div v-else class="flex container mx-auto gap-10">
            <form
                class="w-1/2 grid grid-cols-2 gap-4 h-min"
                @submit.prevent="book"
            >
                <div class="col-span-1 flex flex-col gap-2">
                    <label for="firstname">First Name</label>
                    <input
                        type="text"
                        name="firstname"
                        id="firstname"
                        class="rounded"
                        v-model="customer.first_name"
                        :class="{
                            'border-red-600': errorFor('customer.first_name'),
                        }"
                    />
                    <ValidationErrors
                        :errors="errorFor('customer.first_name')"
                    />
                </div>
                <div class="col-span-1 flex flex-col gap-2">
                    <label for="lastname">Last Name</label>
                    <input
                        type="text"
                        name="lastname"
                        id="lastname"
                        class="rounded"
                        v-model="customer.last_name"
                        :class="{
                            'border-red-600': errorFor('customer.last_name'),
                        }"
                    />
                    <ValidationErrors
                        :errors="errorFor('customer.last_name')"
                    />
                </div>
                <div class="col-span-2 flex flex-col gap-2">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="rounded"
                        v-model="customer.email"
                        :class="{
                            'border-red-600': errorFor('customer.email'),
                        }"
                    />
                    <ValidationErrors :errors="errorFor('customer.email')" />
                </div>
                <div class="col-span-1 flex flex-col gap-2">
                    <label for="street">Street</label>
                    <input
                        type="text"
                        name="street"
                        id="street"
                        class="rounded"
                        v-model="customer.street"
                        :class="{
                            'border-red-600': errorFor('customer.street'),
                        }"
                    />
                    <ValidationErrors :errors="errorFor('customer.street')" />
                </div>
                <div class="col-span-1 flex flex-col gap-2">
                    <label for="city">City</label>
                    <input
                        type="text"
                        name="city"
                        id="city"
                        class="rounded"
                        v-model="customer.city"
                        :class="{ 'border-red-600': errorFor('customer.city') }"
                    />
                    <ValidationErrors :errors="errorFor('customer.city')" />
                </div>
                <div class="col-span-1 flex flex-col gap-2">
                    <label for="country">Country</label>
                    <input
                        type="text"
                        name="country"
                        id="country"
                        class="rounded"
                        v-model="customer.country"
                        :class="{
                            'border-red-600': errorFor('customer.country'),
                        }"
                    />
                    <ValidationErrors :errors="errorFor('customer.country')" />
                </div>
                <div class="flex gap-4">
                    <div class="flex flex-col w-2/3 gap-2">
                        <label for="county">County</label>
                        <input
                            type="text"
                            name="county"
                            id="county"
                            class="rounded"
                            v-model="customer.county"
                            :class="{
                                'border-red-600': errorFor('customer.county'),
                            }"
                        />
                        <ValidationErrors
                            :errors="errorFor('customer.county')"
                        />
                    </div>
                    <div class="flex flex-col w-1/3 gap-2">
                        <label for="postcode">Postcode</label>
                        <input
                            type="text"
                            name="postcode"
                            id="postcode"
                            class="rounded"
                            v-model="customer.postcode"
                            :class="{
                                'border-red-600': errorFor('customer.postcode'),
                            }"
                        />
                        <ValidationErrors
                            :errors="errorFor('customer.postcode')"
                        />
                    </div>
                </div>
                <hr class="col-span-2 my-2 border-gray-300" />
                <div class="flex flex-col col-span-2 gap-2">
                    <div>Payment Details</div>
                    <div class="flex gap-4">
                        <div
                            id="card-number-element"
                            class="border p-2 rounded bg-white border-gray-500 w-1/2"
                        ></div>
                        <div
                            id="card-expiry-element"
                            class="border p-2 rounded bg-white border-gray-500 w-1/4"
                        ></div>
                        <div
                            id="card-cvc-element"
                            class="border p-2 rounded bg-white border-gray-500 w-1/4"
                        ></div>
                    </div>
                </div>
                <div id="card-errors" role="alert" class="col-span-2"></div>
                <hr class="col-span-2 my-2 border-gray-300" />
                <button
                    :disabled="!checkoutStore.itemsInBasket || loading"
                    type="submit"
                    class="col-span-2 w-full px-4 py-2 mb-2 border border-gray-500 shadow-sm text-base font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-300 disabled:text-gray-500"
                >
                    Book Now!
                </button>
                <div
                    v-if="!checkoutStore.itemsInBasket"
                    class="col-span-2 text-lg text-red-600 text-center"
                >
                    Oops! It looks like your basket is empty. Please add one or
                    more bookings to checkout.
                </div>
            </form>
            <div class="w-1/4 ml-auto">
                <div class="flex justify-between">
                    <h3 class="font-medium text-2xl">Your Cart</h3>
                    <span
                        class="inline-flex items-center px-3 py-0.5 rounded-md text-sm font-medium bg-gray-500 text-white mb-4"
                    >
                        <span v-if="checkoutStore.itemsInBasket">
                            {{ checkoutStore.itemsInBasket }}
                        </span>
                        <span v-else> Empty </span>
                    </span>
                </div>
                <TransitionGroup
                    leave-active-class="transition duration-500 absolute w-full"
                    leave-to-class="opacity-0 translate-x-full"
                    move-class="transition duration-500"
                >
                    <div
                        v-for="item in checkoutStore.basket.items"
                        :key="item.booking.id"
                    >
                        <div
                            class="py-2 flex border border-t-gray-500 justify-between font-medium"
                        >
                            <span class="hover:opacity-50">
                                <router-link
                                    :to="{
                                        name: 'booking',
                                        params: { id: item.booking.id },
                                    }"
                                    >{{ item.booking.title }}</router-link
                                >
                            </span>
                            <span> £{{ item.price.total }} </span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span>
                                From:
                                {{
                                    format(
                                        new Date(item.dates.from),
                                        "dd/MM/yyyy"
                                    )
                                }}
                            </span>
                            <span>
                                To:
                                {{
                                    format(
                                        new Date(item.dates.to),
                                        "dd/MM/yyyy"
                                    )
                                }}
                            </span>
                        </div>
                        <div class="w-full flex justify-end">
                            <div
                                class="group p-1 w-8 h-8 mb-2 border border-gray-500 rounded-md flex place-content-center cursor-pointer hover:bg-gray-500"
                                @click="
                                    checkoutStore.removeFromBasket(
                                        item.booking.id
                                    )
                                "
                            >
                                <TrashIcon
                                    class="fill-gray-500 group-hover:fill-white"
                                />
                            </div>
                        </div>
                    </div>
                </TransitionGroup>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCheckoutStore } from "../stores/checkout";
import { format } from "date-fns";
import TrashIcon from "../components/icons/TrashIcon";
import { ref } from "vue";
import ValidationErrors from "../components/ui/ValidationErrors";
import { computed, onMounted } from "vue";
import { useIsError } from "../utils/useMethods";
import Success from "../components/ui/Success";

const checkoutStore = useCheckoutStore();

const loading = ref(false);
const status = ref(null);
const errors = ref(null);
const bookingSuccessful = ref(false);

const hasErrors = computed(() => status.value === 422 && errors.value !== null);
const success = computed(
    () =>
        !loading.value &&
        !checkoutStore.itemsInBasket &&
        bookingSuccessful.value
);

const customer = ref({
    first_name: "",
    last_name: "",
    email: "",
    street: "",
    city: "",
    country: "",
    county: "",
    postcode: "",
});

const reservations = computed(() =>
    checkoutStore.basket.items.map((basketItem) => ({
        booking_id: basketItem.booking.id,
        from: basketItem.dates.from,
        to: basketItem.dates.to,
    }))
);

const addressId = ref(null);

function book() {
    loading.value = true;
    errors.value = null;
    bookingSuccessful.value = false;
    axios
        .post("api/v1/payment-intent", {
            reservations: reservations.value,
            customer: customer.value,
        })
        .then((response) => {
            addressId.value = response.data.data.address_id;
            stripe
                .confirmCardPayment(
                    response.data.data.paymentIntentClientSecret,
                    {
                        payment_method: {
                            card: cardNumber,
                            billing_details: {
                                name: `${customer.value.first_name} ${customer.value.last_name}`,
                                address: {
                                    postal_code: customer.value.postcode,
                                },
                            },
                        },
                    }
                )
                .then((response) => {
                    if (response.error) {
                        let displayError =
                            document.getElementById("card-errors");
                        displayError.textContent = "Something went wrong!";
                    } else {
                        axios
                            .post("/api/v1/checkout", {
                                reservations: reservations.value,
                                address_id: addressId.value,
                            })
                            .then((response) => {
                                status.value = response.status;
                                bookingSuccessful.value = true;
                                checkoutStore.clearBasket();
                            });
                    }
                });
        })
        .catch((error) => {
            if (useIsError(error, 422)) {
                errors.value = error.response.data.errors;
            }
            status.value = error.response.status;
        })
        .then(() => {
            loading.value = false;
        });
}

function errorFor(field) {
    return hasErrors.value && errors.value[field] ? errors.value[field] : null;
}

const stripe = Stripe(process.env.MIX_STRIPE_KEY);
const elements = stripe.elements();
const style = {
    complete: {
        color: "#22c55e",
    },
};
const cardNumber = elements.create("cardNumber", { style });
const cardExpiry = elements.create("cardExpiry", { style });
const cardCvc = elements.create("cardCvc", { style });

function setUpStripeElements() {
    cardNumber.mount("#card-number-element");
    cardExpiry.mount("#card-expiry-element");
    cardCvc.mount("#card-cvc-element");

    cardNumber.on("change", ({ error }) => {
        let displayError = document.getElementById("card-errors");
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = "";
        }
    });

    cardExpiry.on("change", ({ error }) => {
        let displayError = document.getElementById("card-errors");
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = "";
        }
    });

    cardCvc.on("change", ({ error }) => {
        let displayError = document.getElementById("card-errors");
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = "";
        }
    });
}

onMounted(() => {
    setUpStripeElements();
});
</script>
