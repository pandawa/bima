<script setup>

import Layout from "@/Shared/Layouts/StackedLayout.vue";
import Table from "@/Environment/Components/Table.vue";
import CreateEnvironment from "@/Environment/Containers/CreateEnvironment.vue";
import {ref} from "vue";
import UpdateEnvironment from "@/Environment/Containers/UpdateEnvironment.vue";

defineProps({
    environments: Array,
})

const showCreate = ref(false);
const selectedEnvironment = ref(null);

const close = () => {
    selectedEnvironment.value = null;
}

</script>

<template>
    <Layout current="Environments">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold leading-tight tracking-tight text-gray-900">Environments</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button @click="showCreate = true" type="button" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            New Environment
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <div class="mx-auto max-w-5xl mt-5">
            <Table @selected="selectedEnvironment = $event" :environments="environments" />
        </div>

        <CreateEnvironment @closed="showCreate = false" :open="showCreate" />
        <UpdateEnvironment :environment="selectedEnvironment" @closed="close" />
    </Layout>
</template>
