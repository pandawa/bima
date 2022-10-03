<template>
    <div class="rounded-lg shadow bg-white">
        <Link :href="url">
            <div class="-ml-4 px-4 py-5 sm:px-6 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-indigo-600 flex items-center justify-center text-white rounded-md">
                            <CircleStackIcon class="w-8 h-8" />
                            <!--                        <img class="h-12 w-12 rounded-lg" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />-->
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ instance.name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ instance.url }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <div class="ml-2 mr-4">
                        <connection-status :running="running" :connecting="connecting" />
                    </div>
                    <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </div>
            </div>
        </Link>
        <div class="rounded-b-lg bg-gray-100 px-4 py-4 sm:px-6">
            <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 flex items-center justify-center text-white rounded-md">
                        <SparklesIcon class="w-6 h-6" />
                    </div>

                    <div class="truncate pl-2 py-2 text-sm">
                        <a class="text-sm font-medium text-gray-500">Jobs per minute</a>
                        <p class="text-sm text-gray-900 font-medium">
                            <animation-number v-if="stats.jobsPerMinute" :number="stats.jobsPerMinute"></animation-number>
                            <template v-else>
                                -
                            </template>
                        </p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 flex items-center justify-center text-white rounded-md">
                        <ServerIcon class="w-6 h-6" />
                    </div>

                    <div class="truncate pl-2 py-2 text-sm">
                        <a class="text-sm font-medium text-gray-500">Processes</a>
                        <p class="text-sm text-gray-900 font-medium">
                            <animation-number v-if="stats.processes" :number="stats.processes" />
                            <template v-else>
                                -
                            </template>
                        </p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 flex items-center justify-center text-white rounded-md">
                        <XMarkIcon class="w-6 h-6" />
                    </div>

                    <div class="truncate pl-2 py-2 text-sm">
                        <a class="text-sm font-medium text-gray-500">Failed jobs</a>
                        <p class="text-sm text-gray-900 font-medium">
                            <animation-number v-if="stats.failedJobs" :number="stats.failedJobs" />
                            <template v-else>
                                -
                            </template>
                        </p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 flex items-center justify-center text-white rounded-md">
                        <ClockIcon class="w-6 h-6" />
                    </div>

                    <div class="truncate pl-2 py-2 text-sm">
                        <a class="text-sm font-medium text-gray-500">Max wait time</a>
                        <p class="text-sm text-gray-900 font-medium">
                            {{ stats.maxWaitTime != null ? humanTime(stats.maxWaitTime) : '-' }}
                        </p>
                    </div>
                </div>
            </dl>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import { ChevronRightIcon, SparklesIcon, CircleStackIcon, ServerIcon, XMarkIcon, ClockIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/inertia-vue3'
import AnimationNumber from "@/Shared/Components/AnimationNumber";
import ConnectionStatus from "@/Shared/Components/ConnectionStatus";

export default {
    components: {
        AnimationNumber,
        ConnectionStatus,
        ChevronRightIcon,
        SparklesIcon,
        CircleStackIcon,
        ServerIcon,
        XMarkIcon,
        ClockIcon,
        Link
    },
    props: {
        instance: Object,
        connecting: Boolean,
        running: Boolean,
        stats: Object,
        url: String,
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
