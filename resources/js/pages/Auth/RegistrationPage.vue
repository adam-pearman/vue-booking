<template>
    <div class="h-full flex items-center justify-center pb-12 px-4 sm:px-6 lg:px-8 fixed top-12 left-0 right-0">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Register for an Account</h2>
                <p class="mt-2 text-center text-gray-600">
                    Or
                    {{ ' ' }}
                    <router-link :to="{ name: 'login' }" class="font-medium hover:opacity-50"> login </router-link>
                    {{ ' '}}
                    if you already have one.
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true" />
                <div>
                    <label for="full-name" class="sr-only">Full Name</label>
                    <input id="full-name"
                           name="name"
                           type="text"
                           autocomplete="name"
                           required=""
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           :class="errorFor('email') ? 'border-red-600' : 'border-gray-300'"
                           placeholder="Full Name"
                           v-model="form.name"/>
                    <ValidationErrors :errors="errorFor('name')"/>
                </div>
                <div>
                    <label for="email-address" class="sr-only">Email Address</label>
                    <input id="email-address"
                           name="email"
                           type="email"
                           autocomplete="email"
                           required=""
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           :class="errorFor('email') ? 'border-red-600' : 'border-gray-300'"
                           placeholder="Email Address"
                           v-model="form.email"/>
                    <ValidationErrors :errors="errorFor('email')"/>
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password"
                           name="password"
                           type="password"
                           required=""
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           :class="errorFor('password') ? 'border-red-600' : 'border-gray-300'"
                           placeholder="Password"
                           v-model="form.password"/>
                    <ValidationErrors :errors="errorFor('password')"/>
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation"
                           name="password_confirmation"
                           type="password"
                           required=""
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           :class="errorFor('password') ? 'border-red-600' : 'border-gray-300'"
                           placeholder="Confirm Password"
                           v-model="form.password_confirmation"/>
                    <ValidationErrors :errors="errorFor('password_confirmation')"/>
                </div>

                <div>
                    <button @click.prevent="register"
                            type="submit"
                            :disabled="loading"
                            class="group relative w-full flex justify-center py-2 px-4 border border-gray-500 text-sm
                            font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 hover:text-gray-500
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                            disabled:bg-gray-300 disabled:text-gray-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import ValidationErrors from "../../components/ui/ValidationErrors"
import {ref, computed} from "vue";
import {useIsError} from "../../utils/useMethods";
import {useAuthStore} from "../../stores/auth";
import {storageLogin} from "../../utils/useAuthHelpers";
import {useRouter} from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

const loading = ref(false);
const status = ref(null);
const errors = ref(null);
const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const hasErrors = computed(() => status.value === 422 && errors.value !== null);

function errorFor(field) {
    return hasErrors.value && errors.value[field] ? errors.value[field] : null;
}

function register() {
    loading.value = true;
    axios.get('/sanctum/csrf-token').then(() => {
        axios.post('/register', {
            name: form.value.name,
            email: form.value.email,
            password: form.value.password,
            password_confirmation: form.value.password_confirmation,
        }).then((response) => {
            errors.value = null;
            status.value = response.status;
            storageLogin();
            authStore.getAuthUser();
            router.push({name: 'home'});
        }).catch((error) => {
            if (useIsError(error, 422)) {
                errors.value = error.response.data.errors;
            }
            status.value = error.response.status;
        }).then(() => {
            loading.value = false;
        });
    });
}

</script>
