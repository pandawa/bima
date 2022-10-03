<template>
    <Layout>
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">Instances</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button type="button" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            New Instance
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <div class="mx-auto max-w-3xl mt-5">
            <instance-card v-for="instance in instances" class="mb-4"
                           :url="'/instances/' + instance.id"
                           :instance="instance" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../Shared/Layouts/StackedLayout'
import InstanceCard from '../Containers/Card'

export default {
    components: {
        Layout,
        InstanceCard
    },
    props: {
        instances: Array,
    },
}
</script>
