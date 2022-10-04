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
                    <job-detail :job="job" />

                    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Job Data
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Entire data object.</p>
                        </div>
                        <div>
                            <json-viewer :show-double-quotes="true" expand-depth="6" theme="json-view-theme jv-light" copyable :value="prettyPrintJob(job.payload.data)"></json-viewer>
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

export default {
    components: {
        SideBarLayout,
        JobDetail,
        JsonViewer
    },

    props: {
        current: String,
        job_id: Number,
        instance: Object,
    },

    data() {
        return {
            job: null,
        };
    },

    mounted() {
        this.fetchJob(this.job_id);
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
                    this.job = response.data;
                });
        },

        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },
    }
}
</script>
