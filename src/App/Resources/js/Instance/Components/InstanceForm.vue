<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import InputError from "@/Shared/Components/InputError.vue";
import ActionMessage from "@/Shared/Components/ActionMessage.vue";
import Select from "@/Shared/Components/Select.vue";

const props = defineProps({
    instance: Object,
    environments: Array,
    url: String,
    errorBag: String,
})

const loading = ref(false)

const form = useForm({
    name: props.instance?.name || '',
    url: props.instance?.url || '',
    environment_id: props.instance?.environment_id || null,
})

const submit = () => {
    loading.value = true;

    form.post(props.url, {
        errorBag: props.errorBag,
        onFinish: () => loading.value = false,
    });
}
</script>

<template>
    <form @submit.prevent="submit" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
        <div class="px-4 py-6 sm:p-8">
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1">
                        <input :disabled="loading" v-model="form.name" placeholder="Your Horizon instance name" type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="url" class="block text-sm font-medium text-gray-700">Horizon URL</label>
                    <div class="mt-1">
                        <input :disabled="loading" v-model="form.url" placeholder="https://yourdomain.com/horizon" type="text" name="url" id="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="url" class="block text-sm font-medium text-gray-700">Environment</label>
                    <div class="mt-1">
                        <Select :disabled="loading" text-key="name" v-model="form.environment_id" :options="environments" />
                        <InputError :message="form.errors.environment_id" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div :class="{'opacity-50': loading}" class="flex items-center gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
            <button :disabled="loading" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <template v-if="loading">
                    <span class="flex">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving
                    </span>
                </template>
                <template v-else>
                    Update instance
                </template>
            </button>
            <ActionMessage :on="form.recentlySuccessful">Saved.</ActionMessage>
        </div>
    </form>
</template>

<style scoped>

</style>
