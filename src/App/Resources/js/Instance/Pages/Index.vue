<template>
    <Layout current="Instances">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold leading-tight tracking-tight text-gray-900">Instances</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button @click.prevent="showCreate = !showCreate" type="button" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            New Instance
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <div class="mx-auto max-w-3xl mt-5 pb-5">
            <instance-card v-for="instance in availableInstances" class="mb-4"
                           :url="'/instances/' + instance.id"
                           :instance="instance" />
        </div>

        <create-instance @created="addInstance($event)" @closed="showCreate = false" :show="showCreate" />
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layouts/StackedLayout'
import InstanceCard from '../Containers/Card'
import CreateInstance from "@/Instance/Containers/Create";

export default {
    components: {
        Layout,
        InstanceCard,
        CreateInstance
    },
    props: {
        instances: Array,
    },

    data() {
        return {
            showCreate: false,
            availableInstances: [],
        };
    },

    mounted() {
        this.availableInstances = this.instances;
    },

    methods: {
        addInstance(instance) {
            this.showCreate = false;
            this.availableInstances = [
                instance,
                ...this.availableInstances,
            ];
        }
    }
}
</script>
