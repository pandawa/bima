<script setup>
import {ref} from "vue";
import ConfirmationDialog from "@/Shared/Components/ConfirmationDialog.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    url: String,
})

const loading = ref(false);
const confirm = ref(false);

const submit = () => {
    loading.value = true;
    confirm.value = false;
    setTimeout(() => Inertia.delete(props.url), 1000);
}
</script>

<template>
    <div>
        <form @submit.prevent="confirm = true" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-5">
                        <div class="max-w-xl text-sm text-gray-500">
                            Once your instance is deleted, all of its resources and data will be permanently deleted. Before deleting your instance, please download any data or information that you wish to retain.
                        </div>
                    </div>
                </div>
            </div>

            <div :class="{'opacity-50': loading}" class="flex items-center gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                <button :disabled="loading" type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <template v-if="loading">
                    <span class="flex">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Deleting
                    </span>
                    </template>
                    <template v-else>
                        Delete instance
                    </template>
                </button>
            </div>
        </form>

        <ConfirmationDialog @confirmed="submit" :show="confirm" @canceled="confirm = false" title="Delete instance" confirm-text="Delete">
            This action is permanent action. Once your instance is deleted, all of its resources and data will be permanently deleted.
        </ConfirmationDialog>
    </div>
</template>

<style scoped>

</style>
