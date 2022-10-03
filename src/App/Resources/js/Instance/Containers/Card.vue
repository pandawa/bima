<template>
    <instance-card class="mb-4"
                   :running="running"
                   :stats="stats"
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
    },

    data() {
        return {
            connecting: true,
            running: false,
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
        this.fetchStats();
    },
    methods: {
        fetchStats() {
            this.axios
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

                    setTimeout(() => this.fetchStats(), 5000);
                })
                .catch(() => {
                    this.setState(true, false);
                    setTimeout(() => {
                        this.setState(true, false);
                        this.fetchStats()
                    }, 5000);
                });
        },
        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },
        setState(connecting, running) {
            this.running = running;
            this.connecting = connecting;
        }
    }
}
</script>
