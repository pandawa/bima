<template>
    <instance-card class="mb-4"
                   :running="running"
                   :stats="stats"
                   :url="url"
                   :connecting="connecting"
                   :instance="instance" />
</template>

<script>
import _ from 'lodash'
import InstanceCard from '../Components/Card'

export default {
    components: {
        InstanceCard,
    },

    props: {
        instance: Object,
        url: String,
    },

    data() {
        return {
            connecting: true,
            running: false,
            timeout: null,
            stats: {
                jobsPerMinute: null,
                processes: null,
                failedJobs: null,
                maxWaitTime: null,
            },
        };
    },

    mounted() {
        this.setState(true, false);

        this.refreshPeriodically();
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
                    this.stats.processes = result.data.processes;
                    this.stats.jobsPerMinute = result.data.jobsPerMinute;

                    if (_.values(result.data.wait).length) {
                        this.stats.maxWaitTime = _.values(result.data.wait)[0];
                    } else {
                        this.stats.maxWaitTime = null;
                    }
                })
                .catch(() => {
                    this.setState(true, false);
                    this.reset();
                });
        },

        reset() {
            this.stats = {
                failedJobs: null,
                processes: null,
                jobsPerMinute: null,
                maxWaitTime: null,
            };
        },

        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },

        setState(connecting, running) {
            this.running = running;
            this.connecting = connecting;
        },

        refreshPeriodically() {
            Promise.all([
                this.fetchStats(),
            ]).finally(() => {
                this.timeout = setTimeout(() => this.refreshPeriodically(), 5000);
            });
        },
    }
}
</script>
