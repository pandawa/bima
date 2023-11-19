<script setup>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from '@headlessui/vue'
import UserForm from "@/User/Components/UserForm";
import {ref, watch} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(['closed']);

const form = useForm({
    name: '',
    email: '',
})

const open = ref(false);
const creating = ref(false);

const close = () => {
    open.value = false;

    emit('closed');
};

const create = (form) => {
    creating.value = true;
    form.post(route('user.store'), {
        preserveScroll: true,
        errorBag: 'createUser',
        onSuccess: () => {
            emit('created');

            open.value = false;
        },
        onFinish: () => creating.value = false,
    })
};

watch(() => props.show, (newShow) => {
    open.value = newShow;
});
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="close()">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="border-b border-gray-200 bg-white pb-5 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Add new user</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Enter the user details.
                                </p>
                            </div>
                            <div class="px-6 py-4 text-sm">
                                <UserForm :loading="creating" @submitted="create($event)" @closed="close()" />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
