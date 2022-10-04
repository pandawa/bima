<template>
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
        <div v-if="type === 'failed'" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Attempts</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ job.payload.attempts }}
            </dd>
        </div>
        <div v-if="type === 'failed'" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Retries</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ retriedBy.length ?? 0 }}
            </dd>
        </div>

        <div v-if="job.payload.retry_of" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Retry of ID</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <Link class="font-medium text-indigo-500" :href="'/instances/' + instance.id + '/failed/' + job.payload.retry_of">
                    {{ job.payload.retry_of }}
                </Link>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Pushed At</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ readableTimestamp(job.payload.pushedAt) }}
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
            <dt class="text-sm font-medium text-gray-500">Batch</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ prettyPrintJob(job.payload.data).batchId ?? '-' }}
            </dd>
        </div>
        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Tags</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ job.payload.tags && job.payload.tags.length ? job.payload.tags.join(', ') : '' }}
            </dd>
        </div>
        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Runtime</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                {{ job.completed_at ? (job.completed_at - job.reserved_at).toFixed(2)+'s' : '-' }}
            </dd>
        </div>
    </dl>
</template>

<script>
import moment from "moment-timezone";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: {
        type: String,
        job: Object,
        retriedBy: Array,
        instance: Object,
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
