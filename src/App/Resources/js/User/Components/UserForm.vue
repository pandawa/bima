<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import InputError from "@/Shared/Components/InputError.vue";

const props = defineProps({
    loading: Boolean,
})

const form = useForm({
    name: null,
    email: null,
})

</script>

<template>
    <form @submit.prevent="$emit('submitted', form)" class="grid grid-cols-1 gap-y-4">
        <div class="sm:col-span-6">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
                <input v-model="form.name" placeholder="User full name" type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </div>

        <div class="sm:col-span-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input v-model="form.email" placeholder="User email address" type="email" name="email" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
        </div>

        <div :class="{'opacity-50': loading}" class="sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
            <button :disabled="loading" type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">
                <template v-if="loading">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving
                </template>
                <template v-else>
                    Add User
                </template>
            </button>
            <button :disabled="loading" type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm" @click="$emit('closed')">
                Cancel
            </button>
        </div>
    </form>
</template>
