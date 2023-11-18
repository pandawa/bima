<template>
    <auth-layout>
        <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-24 w-auto" :src="$page.props.auth_logo"  />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <div v-if="error" class="rounded-md bg-red-50 p-4 mb-5">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ error }}</h3>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="login()" class="space-y-6" method="POST">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input v-model="auth.email" id="email" name="email" type="email" autocomplete="email" required="" class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input v-model="auth.password" id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div>
                            <button :disabled="loading" :class="{'opacity-50': loading}" type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <template v-if="loading">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Signing
                                </template>
                                <template v-else>
                                    Sign in
                                </template>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </auth-layout>
</template>

<script>
import AuthLayout from "@/Shared/Layouts/AuthLayout";
import {XCircleIcon} from '@heroicons/vue/20/solid'

export default {
    components: {
        AuthLayout,
        XCircleIcon,
    },

    data() {
        return {
            loading: false,
            auth: {
                email: null,
                password: null,
            },
            error: null,
        };
    },

    methods: {
        login() {
            if (this.auth.email && this.auth.password) {
                const auth = { ...this.auth };

                this.auth.password = null;
                this.error = null;
                this.loading = true;

                this.axios.post('/api/auth/login', auth)
                    .then(response => {
                        if (false === response.data.data) {
                            this.loading = false;
                            this.error = 'Email or password invalid.';

                            return;
                        }

                        window.location.href = '/instances';
                    });
            }
        }
    }
}
</script>
