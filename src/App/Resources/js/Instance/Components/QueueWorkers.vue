<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Status</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Supervisor</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Processes</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Memory</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Timeout</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Queues</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Balancing</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="worker in workers">
                <tr>
                    <td colspan="6" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 bg-gray-100 border-b">
                        {{ worker.name }}
                    </td>
                    <td class="text-right whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-medium bg-gray-100 border-b">
                        <div v-if="worker.status == 'paused'" class="flex items-center text-yellow-600 ml-auto">
                            <PauseCircleIcon class="mr-1 h-6 w-6"></PauseCircleIcon>
                            Paused
                        </div>
                    </td>
                </tr>
                <template v-if="worker.status != 'paused'">
                    <tr v-for="(supervisor, index) in worker.supervisors" :class="index % 2 === 0 ? undefined : 'bg-gray-50'">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div v-if="supervisor.status == 'running'" class="flex items-center text-green-600 ml-auto">
                                <CheckCircleIcon class="mr-1 h-6 w-6"></CheckCircleIcon>
                                Running
                            </div>
                            <div v-if="supervisor.status == 'paused'" class="flex items-center text-yellow-600 ml-auto">
                                <PauseCircleIcon class="mr-1 h-6 w-6"></PauseCircleIcon>
                                Paused
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 font-medium">
                            {{ superVisorDisplayName(supervisor.name, worker.name) }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ countProcesses(supervisor.processes) }} / {{ stats.totalProcesses }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ supervisor.options.memory }}MB
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ supervisor.options.timeout }} sec
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ supervisor.options.queue.replace(/,/g, ', ') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 capitalize">
                            {{ supervisor.options.balance ? supervisor.options.balance : 'Disabled' }}
                        </td>
                    </tr>
                </template>
            </template>
        </tbody>
    </table>
</template>

<script>
import {
    CheckCircleIcon,
    PauseCircleIcon,
} from '@heroicons/vue/24/outline'
import _ from "lodash";

export default {
    components: {
        CheckCircleIcon,
        PauseCircleIcon,
    },

    props: {
        workers: Array,
        stats: Object,
    },

    methods: {
        superVisorDisplayName(supervisor, worker) {
            return _.replace(supervisor, worker + ':', '');
        },

        countProcesses(processes) {
            return _.chain(processes).values().sum().value().toLocaleString()
        },
    }
}
</script>
