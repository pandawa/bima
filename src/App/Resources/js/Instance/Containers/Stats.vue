<template>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.job" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Jobs per minute</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900">
                    <animation-number v-if="stats.jobsPerMinute" :number="stats.jobsPerMinute" />
                    <template v-else>
                        -
                    </template>
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">
                    {{ recentJobsPeriod }}
                </p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900 capitalize">
                    <animation-number v-if="stats.jobsPastHour" :number="stats.jobsPastHour" />
                    <template v-else>
                        -
                    </template>
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.failed" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Failed jobs past 7 days</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900">
                    <animation-number v-if="stats.failedJobs" :number="stats.failedJobs" />
                    <template v-else>
                        -
                    </template>
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.status" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Status</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900 capitalize">
                    {{ stats.status ?? '-' }}
                </p>
            </dd>
        </div>
    </dl>

    <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.server" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Total processes</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900">
                    <animation-number v-if="stats.totalProcesses" :number="stats.totalProcesses" />
                    <template v-else>
                        -
                    </template>
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.maxWaitTime" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Max wait time</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900">
                    {{ stats.maxWaitTime !== null ? humanTime(stats.maxWaitTime) : '-' }}
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Max runtime</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900 capitalize">
                    {{ stats.maxRuntime ?? '-' }}
                </p>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-white px-3 py-4 shadow">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <component :is="icons.maxThroughput" class="h-6 w-6 text-white" aria-hidden="true" />
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Max througput</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-lg font-semibold text-gray-900 capitalize">
                    {{ stats.maxThroughput ?? '-' }}
                </p>
            </dd>
        </div>
    </dl>
</template>

<script>
import {
    ArrowsRightLeftIcon,
    ClockIcon,
    HeartIcon,
    ServerIcon,
    SparklesIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

import AnimationNumber from '@/Shared/Components/AnimationNumber'
import moment from "moment/moment";

export default {
    components: {
        AnimationNumber,
        SparklesIcon,
        XMarkIcon,
        HeartIcon,
        ServerIcon,
        ClockIcon,
        ArrowsRightLeftIcon,
    },
    props: {
        instance: Object,
        stats: Object,
    },

    data() {
        return {
            icons: {
                job: SparklesIcon,
                failed: XMarkIcon,
                status: HeartIcon,
                server: ServerIcon,
                maxWaitTime: ClockIcon,
                maxThroughput: ArrowsRightLeftIcon,
            }
        };
    },

    computed: {
        recentJobsPeriod() {
            return !this.jobsPastHour
                ? 'Jobs past hour'
                : `Jobs past ${this.determinePeriod(this.stats.recentJobsPeriod)}`;
        }
    },

    methods: {

        humanTime(time) {
            return moment.duration(time, "seconds").humanize().replace(/^(.)|\s+(.)/g, function ($1) {
                return $1.toUpperCase();
            });
        },

        determinePeriod(minutes) {
            return moment.duration(moment().diff(moment().subtract(minutes, "minutes"))).humanize().replace(/^An?/i, '');
        }
    }
}
</script>
