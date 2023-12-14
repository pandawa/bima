<script>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";

export default {
    components: {
        TransitionChild,
        TransitionRoot,
        Dialog,
        DialogPanel,
    },

    props: {
        show: false,
        license: Object,
    }
}
</script>

<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="$emit('close')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform rounded-lg bg-white pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="border-b border-gray-200 bg-white pb-5 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">License Information</h3>
                            </div>
                            <div class="px-6 py-4 text-sm">
                                <dl class="space-y-2 divide-y divide-gray-100 text-sm leading-6">
                                    <div class="pt-6 sm:flex">
                                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Name</dt>
                                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                                            <div class="text-gray-900">{{ license.name }}</div>
                                        </dd>
                                    </div>
                                    <div class="pt-2 sm:flex">
                                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Plan</dt>
                                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                                            <div class="text-gray-900">{{ license.plan }}</div>
                                        </dd>
                                    </div>
                                    <div class="pt-2 sm:flex">
                                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Instance Limit</dt>
                                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                                            <div class="text-gray-900">{{ license.instance_limit }}</div>
                                        </dd>
                                    </div>
                                    <div class="pt-2 sm:flex">
                                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Expiration Date</dt>
                                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                                            <div class="text-gray-900">{{ license.expiration_date }}</div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
