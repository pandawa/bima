<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import InputError from "@/Shared/Components/InputError.vue";
import Loader from "@/Shared/Components/Loader.vue";
import {ref} from "vue";

const props = defineProps({
    environment: Object,
    url: String,
    errorBag: String,
});

const emit = defineEmits(['closed'])
const loading = ref(false);

const form = useForm({
    name: props.environment?.name || '',
});

const submit = () => {
    loading.value = true;

    form.post(props.url, {
        errorBag: props.errorBag,
        onSuccess: () => {
            emit('closed');
        },
        onError: () => {
            loading.value = false;
        }
    })
}
</script>

<template>
    <form @submit.prevent="submit" class="grid grid-cols-1 gap-y-4">
        <div class="sm:col-span-6">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
                <input :disabled="loading" v-model="form.name" placeholder="Your environment name" type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </div>

        <div :class="{'opacity-50': loading}" class="sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
            <button :disabled="loading" type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm">
                <template v-if="loading">
                    <Loader />
                    Saving
                </template>
                <template v-else>
                    {{ !!environment ? 'Update Environment' : 'Add Environment' }}
                </template>
            </button>
            <button :disabled="loading" type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm" @click="$emit('closed')">
                Cancel
            </button>
        </div>
    </form>
</template>
