<template>
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ job.name }}</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ job.id }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Queue</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ job.queue }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Pushed At</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ readableTimestamp(job.payload.pushedAt) }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Batch</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ prettyPrintJob(job.payload.data).batchId ?? '-' }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6" v-if="delayed">
                    <dt class="text-sm font-medium text-gray-500">Delay Until</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ delayed }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Completed At</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ job.completed_at ? readableTimestamp(job.completed_at) : '-'}}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Runtime</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ job.completed_at ? (job.completed_at - job.reserved_at).toFixed(2)+'s' : '-' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>

<script>
import moment from "moment-timezone";

export default {
    props: {
        job: Object,
    },

    computed: {
        unserialized() {
            return phpunserialize(this.job.payload.data.command);
        },

        delayed() {
            let unserialized;

            try {
                unserialized = phpunserialize(this.job.payload.data.command);
            }catch(err){
                //
            }

            if (unserialized && unserialized.delay && unserialized.delay.date) {
                return moment.tz(unserialized.delay.date, unserialized.delay.timezone)
                    .local()
                    .format('YYYY-MM-DD HH:mm:ss');
            } else if (unserialized && unserialized.delay) {
                return this.formatDate(this.job.payload.pushedAt).add(unserialized.delay, 'seconds')
                    .local()
                    .format('YYYY-MM-DD HH:mm:ss');
            }

            return null;
        },
    }
}
</script>

<style scoped>

</style>
