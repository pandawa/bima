<template>
    <Listbox as="div" v-model="selected">
        <div class="relative">
            <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <span class="block truncate" v-if="selected">{{ selected[textKey] }}</span>
                <span class="block truncate text-gray-400" v-else>{{ placeholder }}</span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                  <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="item in options" :key="item[valueKey]" :value="item" v-slot="{ active, selected }">
                        <li :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ item[textKey] }}</span>

                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
import {computed} from 'vue'
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from '@headlessui/vue'
import {CheckIcon, ChevronUpDownIcon} from '@heroicons/vue/20/solid'

const props = defineProps({
    options: {
        type: Array,
        default: [],
    },
    valueKey: {
        type: String,
        default: 'id'
    },
    textKey: {
        type: String,
        default: 'text'
    },
    placeholder: {
        type: String,
        default: 'Select',
    },
    modelValue: Number|String
})

const emit = defineEmits(['update:modelValue']);

const selected = computed({
    get() {
        return props.options.find((item) => item[props.valueKey] === props.modelValue)
    },

    set(val) {
        emit('update:modelValue', val[props.valueKey]);
    }
})
</script>
