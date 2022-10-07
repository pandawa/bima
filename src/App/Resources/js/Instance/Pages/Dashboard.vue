<template>
    <side-bar-layout :instance="instance" :current="'Dashboard'">
        <template v-slot:header>
            <h1 class="text-lg font-semibold text-gray-900 mr-3">Dashboard</h1>
            <connection-status :connecting="connecting" :running="running" />
        </template>
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Replace with your content -->
                <div class="py-4">
                    <instance-stats :stats="stats" :instance="instance" />
                </div>

                <div class="rounded-lg bg-white mt-2 shadow">
                    <div class="border-b border-gray-200 pb-5 sm:pb-0 px-5 pt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 pb-4">Current Workload</h3>
                    </div>

                    <div class="rounded-b-lg overflow-hidden">
                        <queues-work-load :workload="workload" />
                    </div>
                </div>

                <div class="rounded-lg bg-white mt-5 shadow">
                    <div class="border-b border-gray-200 pb-5 sm:pb-0 px-5 pt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 pb-4">Workers</h3>
                    </div>

                    <div class="rounded-b-lg overflow-hidden">
                        <queue-workers :workers="workers" />
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </div>
    </side-bar-layout>
</template>

<script>
import SideBarLayout from '../../Shared/Layouts/SideBarLayout'
import InstanceStats from '../Containers/Stats'
import _ from "lodash";
import ConnectionStatus from "@/Shared/Components/ConnectionStatus";
import QueuesWorkLoad from "@/Instance/Components/QueuesWorkLoad";
import QueueWorkers from "@/Instance/Components/QueueWorkers";

export default {
    components: {
        ConnectionStatus,
        SideBarLayout,
        InstanceStats,
        QueuesWorkLoad,
        QueueWorkers,
    },
    props: {
        instance: Object,
    },

    data() {
        return {
            running: false,
            connecting: true,
            timeout: null,
            workload: [],
            workers: [],
            stats: {
                jobsPerMinute: null,
                jobsPastHour: null,
                failedJobs: null,
                status: null,
                totalProcesses: null,
                maxWaitTime: null,
                maxRuntime: null,
                maxThroughput: null,
                recentJobsPeriod: null,
            },
            tabs: [
                { name: 'Queues', href: '#', current: true },
                { name: 'Workers', href: '#', current: false },
            ],
        };
    },

    mounted() {
        this.refreshStatsPeriodically();
    },

    unmounted() {
        clearTimeout(this.timeout);
    },

    methods: {
        fetchStats() {
            return this.axios
                .get(this.getUrl('/api/stats'), {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(result => {
                    this.setState(false, result.data.status === 'running');

                    this.stats.failedJobs = result.data.failedJobs;
                    this.stats.totalProcesses = result.data.processes;
                    this.stats.jobsPerMinute = result.data.jobsPerMinute;
                    this.stats.jobsPastHour = result.data.recentJobs;
                    this.stats.recentJobsPeriod = result.data.periods.recentJobs;
                    this.stats.status = result.data.status;
                    this.stats.maxRuntime = result.data.queueWithMaxRuntime;
                    this.stats.maxThroughput = result.data.queueWithMaxThroughput;

                    if (_.values(result.data.wait).length) {
                        this.stats.maxWaitTime = _.values(result.data.wait)[0];
                    } else {
                        this.stats.maxWaitTime = null;
                    }
                })
                .catch(() => {
                    this.setState(true, false);
                    this.resetStats();
                });
        },

        fetchWorkLoad() {
            return this.axios
                .get(this.getUrl('/api/workload'), {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(response => {
                    this.workload = response.data;
                })
                .catch(() => this.resetWorkLoad());
        },

        fetchWorkers() {
            return this.axios
                .get(this.getUrl('/api/masters'), {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(response => {
                    this.workers = response.data;
                })
                .catch(() => this.resetWorkers());
        },

        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },

        setState(connecting, running) {
            this.running = running;
            this.connecting = connecting;
        },

        refreshStatsPeriodically() {
            Promise.all([
                this.fetchStats(),
                this.fetchWorkLoad(),
                this.fetchWorkers(),
            ]).finally(() => {
                this.timeout = setTimeout(() => this.refreshStatsPeriodically(), 5000);
            });
        },

        resetStats() {
            this.stats = {
                jobsPerMinute: null,
                jobsPastHour: null,
                failedJobs: null,
                status: null,
                totalProcesses: null,
                maxWaitTime: null,
                maxRuntime: null,
                maxThroughput: null,
                recentJobsPeriod: null,
            };
        },

        resetWorkLoad() {
            this.workload = [];
        },

        resetWorkers() {
            this.workers = [];
        }
    }
}
</script>
