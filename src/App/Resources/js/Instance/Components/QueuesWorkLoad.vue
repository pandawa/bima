<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Queue</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Processes</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jobs</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Wait</th>
        </tr>
        </thead>
        <tbody class="bg-white" v-if="workload && workload.length">
            <template v-for="(queue, i) in workload">
                <tr :class="i % 2 === 0 ? undefined : 'bg-gray-50'">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ queue.name.replace(/,/g, ', ') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ queue.processes ? queue.processes.toLocaleString() : 0 }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ queue.length ? queue.length.toLocaleString() : 0 }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ humanTime(queue.wait) }}</td>
                </tr>

                <tr v-for="split_queue in queue.split_queues">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        <svg class="icon info-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/>
                        </svg>

                        <span>{{ split_queue.name.replace(/,/g, ', ') }}</span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">-</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ split_queue.length ? split_queue.length.toLocaleString() : 0 }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ humanTime(split_queue.wait) }}</td>
                </tr>
            </template>
        </tbody>
        <template v-else>
            <tbody>
                <tr>
                    <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">There is no current workload</td>
                </tr>
            </tbody>
        </template>
    </table>
</template>

<script>
import moment from "moment/moment";

export default {
    props: {
        workload: Array,
    },

    methods: {
        humanTime(time) {
            return moment.duration(time, "seconds").humanize().replace(/^(.)|\s+(.)/g, function ($1) {
                return $1.toUpperCase();
            });
        },
    }
}
</script>
