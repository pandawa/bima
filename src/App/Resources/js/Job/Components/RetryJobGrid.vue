<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Job</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">ID</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Retry Time</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr v-for="(retry, i) in retries" :class="i % 2 === 0 ? undefined : 'bg-gray-50'">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <div v-if="retry.status == 'reserved' || retry.status == 'pending'" class="flex items-center text-yellow-600 ml-auto">
                        <PauseCircleIcon class="mr-1 h-6 w-6"></PauseCircleIcon>
                        Retrying
                    </div>
                    <div v-if="retry.status == 'completed'" class="flex items-center text-green-600 ml-auto">
                        <CheckCircleIcon class="mr-1 h-6 w-6"></CheckCircleIcon>
                        Completed
                    </div>
                    <div v-if="retry.status == 'failed'" class="flex items-center text-red-600 ml-auto">
                        <XCircleIcon class="mr-1 h-6 w-6"></XCircleIcon>
                        Failed
                    </div>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-medium">
                    <Link class="text-indigo-500" :href="'/instances/' + instance.id + '/' + (retry.status === 'reserved' ? 'pending' : retry.status) + '/' + retry.id">
                        {{ retry.id }}
                    </Link>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{readableTimestamp(retry.retried_at)}}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {CheckCircleIcon, PauseCircleIcon, XCircleIcon} from '@heroicons/vue/24/outline'

export default {
    components: {
        CheckCircleIcon,
        PauseCircleIcon,
        XCircleIcon,
        Link,
    },

    props: {
        instance: Object,
        retries: Array,
    }
}
</script>
