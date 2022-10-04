<template>
    <side-bar-layout :instance="instance" :current="current">
        <template v-slot:header>
            <h1 class="text-lg font-semibold text-gray-900">
                Detail Job: {{ instance.name }}
            </h1>
        </template>
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Replace with your content -->
                <template v-if="job">
                    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    {{ job.name }}
                                </h3>
                                <p class="mt-1 truncate text-sm text-gray-500">Your main job details.</p>
                            </div>
                            <div class="mt-3 flex sm:mt-0 sm:ml-4">
                                <button v-if="type === 'failed'" @click.prevent="retry(job.id)" :class="{'opacity-70': retrying}" :disabled="retrying" type="button" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <template v-if="retrying">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Retrying
                                    </template>
                                    <template v-else>
                                        Retry
                                    </template>
                                </button>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <job-detail :retried-by="retriedBy" :instance="instance" :type="type" :job="job" />
                        </div>
                    </div>

                    <div v-if="type === 'failed'" class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Job Exception
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">The following exception was thrown.</p>
                        </div>
                        <div>
                            <stack-trace :trace="job.exception.split('\n')"></stack-trace>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Job Data
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Entire data object.</p>
                        </div>
                        <div class="bg-gray-800 text-white p-4">
                            <vue-json-pretty :deep="type === 'failed' ? 1 : 6" :collapsed-on-click-brackets="true" :highlight-selected-node="false" :data="prettyPrintJob(jobData)"></vue-json-pretty>
                        </div>
                    </div>

                    <div v-if="type === 'failed' && retriedBy.length" class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Recent Retries
                            </h3>
                        </div>
                        <div>
                            <retry-job-grid :instance="instance" :retries="retriedBy" />
                        </div>
                    </div>

                </template>
                <!-- /End replace -->
            </div>
        </div>
    </side-bar-layout>
</template>

<script>
import SideBarLayout from "@/Shared/Layouts/SideBarLayout";
import JobDetail from "@/Job/Components/JobDetail";
import JsonViewer from 'vue-json-viewer';
import VueJsonPretty from 'vue-json-pretty';
import StackTrace from "@/Shared/Components/StackTrace";
import RetryJobGrid from "@/Job/Components/RetryJobGrid";
import 'vue-json-pretty/lib/styles.css';

export default {
    components: {
        SideBarLayout,
        JobDetail,
        JsonViewer,
        VueJsonPretty,
        StackTrace,
        RetryJobGrid,
    },

    props: {
        current: String,
        job_id: Number,
        instance: Object,
        type: String
    },

    data() {
        return {
            job: null,
            retriedBy: [],
            retrying: false,
            jobData: null,
        };
    },

    mounted() {
        this.fetchJob(this.job_id);

        if (this.type === 'failed') {
            this.interval = setInterval(() => {
                this.reloadRetries();
            }, 3000);
        }
    },

    unmounted() {
        clearTimeout(this.interval);
    },

    methods: {
        fetchJob(id) {
            this.axios
                .get(this.getUrl('/api/jobs/' + id), {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(response => {
                    let job = response.data;

                    if (typeof job.retried_by === 'string') {
                        this.retriedBy = JSON.parse(job.retried_by);
                    }

                    this.job = job;
                    this.jobData = job.payload.data;
                });
        },

        retry(id) {
            if (this.retrying) {
                return;
            }

            this.retrying = true;

            this.axios
                .post(this.getUrl('/api/jobs/retry/' + id), {}, {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(() => {
                    setTimeout(() => {
                        this.reloadRetries();

                        this.retrying = false;
                    }, 3000);
                })
                .catch(() => this.retrying = false);
        },

        reloadRetries() {
            this.axios
                .get(this.getUrl('/api/jobs/failed/' + this.job_id), {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(response => {
                    this.retriedBy = response.data.retried_by;
                });
        },

        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },
    }
}
</script>
