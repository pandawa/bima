<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform rounded-lg bg-white pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <template v-if="step === 2">
                                <div class="border-b border-gray-200 bg-white pb-5 sm:px-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Laravel Configuration</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        To add a new Horizon instance you will need to make the following changes to your Laravel application.
                                    </p>
                                </div>
                                <div class="px-6 py-4 text-sm">
                                    <div class="mt-3 sm:mt-5">
                                        <div>
                                            Install bima client package into your Laravel application:
                                        </div>
                                        <br />
                                        <div class="p-4 bg-gray-800 text-white rounded-lg">
                                            composer require pandawa/bima-client
                                        </div>
                                        <br />
                                        <div>
                                            Open <strong>config/horizon.php</strong> and update horizon middleware to bima middleware:
                                        </div>
                                        <br />
                                        <div class="p-4 bg-gray-800 text-white rounded-lg">
                                            'horizon' => ['bima.auth'],
                                        </div>
                                        <br />
                                        <div>
                                            Open <strong>.env</strong> and add bima secret config:
                                        </div>
                                        <br />
                                        <div class="p-4 bg-gray-800 text-white rounded-lg">
                                            BIMA_SECRET={{ instance.secret }}
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6">
                                        <button @click.prevent="$emit('created', instance)" type="button" class="font-semibold inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
                                            <span class="flex items-center">
                                                Let's Continue
                                                <ArrowRightCircleIcon class="h-5 w-5 ml-1 font-semibold" aria-hidden="true" />
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <template v-if="step === 1">
                                <div class="border-b border-gray-200 bg-white pb-5 sm:px-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Add new Horizon instance</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Enter the instance details.
                                    </p>
                                </div>
                                <div class="px-6 py-4 text-sm">
                                    <instance-form :environments="environments" :loading="creating" @submitted="create($event)" @closed="close()" />
                                </div>
                            </template>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ArrowRightCircleIcon} from '@heroicons/vue/24/solid'
import InstanceForm from "@/Instance/Components/Form";

export default {
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ArrowRightCircleIcon,
        InstanceForm,
    },
    props: {
        show: Boolean,
        environments: Array,
    },
    data() {
        return {
            open: false,
            step: 1,
            creating: false,
            instance: null,
        };
    },

    watch: {
        show() {
            this.open = this.show;
            setTimeout(() => {
                this.step = 1;
                this.instance = null;
            }, 300);
        }
    },

    methods: {
        close() {
            this.open = false;
            this.$emit('closed');
        },

        create(instance) {
            this.creating = true;
            this.axios.post('/api/instances', instance)
                .then(response => {
                    this.creating = false;
                    this.step = 2;
                    this.instance = response.data.data;
                });
        }
    }
}
</script>
