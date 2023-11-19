<script setup>
import {ref, watch} from "vue";
import ConfirmationDialog from "@/Shared/Components/ConfirmationDialog.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import ActionMessage from "@/Shared/Components/ActionMessage.vue";
import SuccessDialog from "@/Shared/Components/SuccessDialog.vue";
import InputSecret from "@/Shared/Components/InputSecret.vue";

const props = defineProps({
    url: String,
    newPassword: String,
})

const loading = ref(false);
const confirm = ref(false);
const displayNewPassword = ref(!!props.newPassword);

const form = useForm({})

watch(() => props.newPassword, (newPassword) => {
    displayNewPassword.value = !!newPassword;
})

const submit = () => {
    loading.value = true;
    confirm.value = false;
    setTimeout(() => {
        form.post(props.url, {
            preserveScroll: true,
            onFinish: () => {
                loading.value = false;
            }
        })
    }, 1000);
}
</script>

<template>
    <div>
        <form @submit.prevent="confirm = true" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-5">
                        <div class="max-w-xl text-sm text-gray-500">
                            The user current password will replace with new random generated password. You will get the new password when reset was succeed.
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
                        Resetting
                    </span>
                    </template>
                    <template v-else>
                        Reset password
                    </template>
                </button>
                <ActionMessage :on="form.recentlySuccessful">Password generated.</ActionMessage>
            </div>
        </form>

        <ConfirmationDialog @confirmed="submit" :show="confirm" @canceled="confirm = false" title="Reset password" confirm-text="Reset">
            This action is permanent action. You will get the new password when reset was succeed.
        </ConfirmationDialog>

        <SuccessDialog @close="displayNewPassword = false" :show="displayNewPassword" title="Your new password">
            <div class="p-2">
                <div class="text-sm text-gray-500">
                    Here is your new password. This password will not shown again after this dialog closed. Please copy it before close this dialog.
                </div>
                <div class="mt-5">
                    <InputSecret v-model="newPassword" />
                </div>
            </div>
        </SuccessDialog>
    </div>
</template>

<style scoped>

</style>
