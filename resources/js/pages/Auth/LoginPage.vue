<template>
    <div class="h-full flex items-center justify-center pb-12 px-4 sm:px-6 lg:px-8 fixed top-12 left-0 right-0">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign In to Your Account</h2>
                <p class="mt-2 text-center text-gray-600">
                    Or
                    {{ ' ' }}
                    <a href="#" class="font-medium hover:opacity-50"> register </a>
                    {{ ' '}}
                    if you don't have one yet.
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true" />
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
                               autocomplete="current-password"
                               required=""
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               :class="errorFor('password') ? 'border-red-600' : 'border-gray-300'"
                               placeholder="Password"
                               v-model="form.password"/>
                        <ValidationErrors :errors="errorFor('password')"/>
                    </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me"
                               name="remember-me"
                               type="checkbox"
                               class="h-4 w-4 text-gray-500 focus:ring-indigo-500 border-gray-500 rounded"
                               v-model="form.remember"/>
                        <label for="remember-me" class="ml-2 block text-sm"> Remember Me </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium hover:opacity-50"> Forgot Your Password? </a>
                    </div>
                </div>

                <div>
                    <button @click.prevent="login"
                            type="submit"
                            :disabled="loading"
                            class="group relative w-full flex justify-center py-2 px-4 border border-gray-500 text-sm
                            font-medium rounded-md text-white bg-gray-500 hover:bg-gray-300 hover:text-gray-500
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                            disabled:bg-gray-300 disabled:text-gray-500">
                        Sign In
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

const authStore = useAuthStore();
const loading = ref(false);
const errors = ref(null);
const status = ref(null);
const form = ref({
    email: '',
    password: '',
    remember: false,
})

const hasErrors = computed(() => status.value === 422 && errors.value !== null);

function errorFor(field) {
    return hasErrors.value && errors.value[field] ? errors.value[field] : null;
}

function login() {
    loading.value = true;
    axios.get('/sanctum/csrf-token').then(() => {
        axios.post('/login', {
            email: form.value.email,
            password: form.value.password,
            remember: form.value.remember,
        }).then(() => {
            errors.value = null;
            authStore.getAuthUser();
        }).catch((error) => {
            if (useIsError(error, 422)) {
                errors.value = error.response.data.errors;
            }
            status.value = error.response.status;
        }).then(() => {
            loading.value=false;
        });
    })
}

</script>
