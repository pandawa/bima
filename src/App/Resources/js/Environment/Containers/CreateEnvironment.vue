<script setup>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import EnvironmentForm from "@/Environment/Components/EnvironmentForm.vue";

defineProps({
    open: false,
})

const submitUrl = route('environment.create')
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="border-b border-gray-200 bg-white pb-5 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Add new environment</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Enter the environment details.
                                </p>
                            </div>
                            <div class="px-6 py-4 text-sm">
                                <EnvironmentForm :url="submitUrl"
                                                 error-bag="createEnvironment"
                                                 @closed="$emit('closed')" />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>

</style>
