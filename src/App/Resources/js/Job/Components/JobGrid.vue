<template>
    <table class="min-w-full divide-y divide-gray-300 table table-hover">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 w-8/12">Job</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Queue</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Queued At</th>
                <th v-if="type === 'completed'" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Completed At</th>
                <th v-if="type === 'completed'" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Runtime</th>
            </tr>
        </thead>
        <tbody class="bg-white" v-if="jobs && jobs.length">
            <component v-for="(job, i) in jobs"
                       :class="i % 2 === 0 ? undefined : 'bg-gray-50'"
                       :instance="instance"
                       :type="type"
                       :job="job"
                       is="job-grid-row"></component>
        </tbody>
        <template v-else>
            <tbody>
                <tr>
                    <td :colspan="type === 'completed' ? 5 : 3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        There aren't any jobs
                    </td>
                </tr>
            </tbody>
        </template>
    </table>
</template>

<script>
import JobGridRow from "@/Job/Components/JobGridRow";

export default {
    components: {
        JobGridRow,
    },

    props: {
        instance: Object,
        jobs: Array,
        type: String,
    }
}
</script>
