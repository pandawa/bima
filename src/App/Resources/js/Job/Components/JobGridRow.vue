<template>
    <tr class="hover:bg-gray-100">
        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            <div class="flex items-center">
                <Link :href="'/instances/' + instance.id + '/'+ type +'/' + job.id">
                    {{ jobBaseName(job.name) }}
                </Link>
                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800"
                      v-tooltip:top="`Delayed for ${delayed}`"
                      v-if="delayed && (job.status == 'reserved' || job.status == 'pending')">
                    Delayed
                </span>
            </div>
            <div class="text-gray-500 text-sm font-normal mt-1">
                <span v-if="job.payload.tags && job.payload.tags.length" class="text-break">
                    Tags: {{ job.payload.tags && job.payload.tags.length ? job.payload.tags.slice(0,3).join(', ') : '' }}<span v-if="job.payload.tags.length > 3"> ({{ job.payload.tags.length - 3 }} more)</span>
                </span>
            </div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{job.queue}}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 pr-4">
            {{ readableTimestamp(job.payload.pushedAt) }}
        </td>
        <template v-if="type === 'completed'">
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 pr-4">
                {{ readableTimestamp(job.completed_at) }}
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 pr-4">
                {{ job.completed_at ? (job.completed_at - job.reserved_at).toFixed(2)+'s' : '-' }}
            </td>
        </template>
    </tr>
</template>

<script>
import phpunserialize from 'phpunserialize'
import moment from 'moment-timezone';
import {Link} from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },

    props: {
        type: String,
        instance: Object,
        job: {
            type: Object,
            required: true
        }
    },

    computed: {
        unserialized() {
            try {
                return phpunserialize(this.job.payload.data.command);
            }catch(err){
                //
            }
        },

        delayed() {
            if (this.unserialized && this.unserialized.delay && this.unserialized.delay.date) {
                return moment.tz(this.unserialized.delay.date, this.unserialized.delay.timezone)
                    .fromNow(true);
            } else if (this.unserialized && this.unserialized.delay) {
                return this.formatDate(this.job.payload.pushedAt).add(this.unserialized.delay, 'seconds')
                    .fromNow(true);
            }

            return null;
        },
    },
}
</script>
