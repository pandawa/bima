<script setup>
import {DocumentDuplicateIcon, EyeIcon, EyeSlashIcon, KeyIcon} from "@heroicons/vue/24/outline";
import {ref} from "vue";

const props = defineProps({
    modelValue: String|Number,
    readonly: Boolean
})

const type = ref('password');

const copy = () => {
    navigator.clipboard.writeText(props.modelValue);
}
</script>

<template>
    <div class="flex">
        <div class="flex flex-grow items-stretch rounded-md shadow-sm">
            <div class="relative flex flex-grow items-stretch focus-within:z-10">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <KeyIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </div>
                <input :readonly="readonly"
                       v-model="modelValue"
                       @input="$emit('update:modelValue', $event.target.value)"
                       :type="type"
                       class="block w-full rounded-none rounded-l-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                <button v-if="type === 'password'" @click="type = 'text'" type="button" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <EyeIcon class="-ml-0.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                </button>
                <button v-if="type === 'text'" @click="type = 'password'" type="button" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <EyeSlashIcon class="-ml-0.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                </button>
            </div>
        </div>
        <button @click.prevent="copy" type="button" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 ml-2">
            <DocumentDuplicateIcon class="h-5 w-5" />
        </button>
    </div>
</template>

<style scoped>

</style>
