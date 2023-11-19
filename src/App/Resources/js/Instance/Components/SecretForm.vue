<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import ActionMessage from "@/Shared/Components/ActionMessage.vue";
import InputSecret from "@/Shared/Components/InputSecret.vue";
import ConfirmationDialog from "@/Shared/Components/ConfirmationDialog.vue";

const props = defineProps({
    instance: Object,
    url: String,
})

const loading = ref(false);
const confirm = ref(false);

const form = useForm({})

const submit = () => {
    loading.value = true;

    form.post(props.url, {
        preserveScroll: true,
        onFinish: () => {
            loading.value = false
            confirm.value = false
        },
    });
}
</script>

<template>
    <div>
        <form @submit.prevent="confirm = true" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-5">
                        <div class="max-w-xl text-sm text-gray-500">
                            This is the client secret to use in your application. This secret is used as authentication for Horizon APIs.
                        </div>
                        <div class="mt-5">
                            <InputSecret v-model="instance.secret" />
                        </div>
                    </div>
                </div>
            </div>

            <div :class="{'opacity-50': loading}" class="flex items-center gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                <button :disabled="loading" type="submit" class="rounded-md bg-amber-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">
                    <template v-if="loading">
                    <span class="flex">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Regenerating
                    </span>
                    </template>
                    <template v-else>
                        Regenerate secret
                    </template>
                </button>
                <ActionMessage :on="form.recentlySuccessful">Regnerated.</ActionMessage>
            </div>
        </form>

        <ConfirmationDialog @confirmed="submit" :show="confirm" @canceled="confirm = false" title="Regenerate secret" confirm-text="Regenerate">
            Regenerate secret is permanent action. You must set new secret on your application. This action cannot be undone.
        </ConfirmationDialog>
    </div>
</template>

<style scoped>

</style>
