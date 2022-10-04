<template>
    <side-bar-layout :instance="instance" :current="current">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Replace with your content -->
                <div class="rounded-lg bg-white mt-5 shadow">
                    <div class="rounded-lg overflow-hidden">
                        <job-grid :type="type" :instance="instance" :jobs="jobs" />

                        <nav v-if="jobs.length && totalPages > 1" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6" aria-label="Pagination">
                            <div class="hidden sm:block">
                                <p class="text-sm text-gray-700">
                                    Showing
                                    {{ ' ' }}
                                    <span class="font-medium">
                                        {{ page }}
                                    </span>
                                    {{ ' ' }}
                                    to
                                    {{ ' ' }}
                                    <span class="font-medium">
                                        {{ totalPages }}
                                    </span>
                                    {{ ' ' }}
                                </p>
                            </div>
                            <div class="flex flex-1 justify-between sm:justify-end">
                                <button :disabled="page==1" :class="{'bg-gray-100': page == 1}" @click="previous" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</button>
                                <button :disabled="page>=totalPages" @click="next" :class="{'bg-gray-100': page>=totalPages}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</button>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </div>
    </side-bar-layout>
</template>

<script>
import SideBarLayout from "@/Shared/Layouts/SideBarLayout";
import JobGrid from "@/Job/Components/JobGrid";

export default {
    components: {
        SideBarLayout,
        JobGrid,
    },

    props: {
        instance: Object,
        current: String,
        type: String,
    },

    data() {
        return {
            interval: null,
            loadingNewEntries: false,
            hasNewEntries: false,
            page: 1,
            perPage: 50,
            totalPages: 1,
            jobs: []
        };
    },

    mounted() {
        this.loadNewEntries();

        this.refreshJobsPeriodically();
    },

    unmounted() {
        clearInterval(this.interval);
    },

    methods: {
        fetchJobs(starting = -1) {
            this.axios
                .get(this.getUrl('/api/jobs/' + this.type)  + '?starting_at=' + starting + '&limit=' + this.perPage, {
                    headers: {
                        Authorization: `Bearer ${this.instance.secret}`,
                    }
                })
                .then(response => {
                    this.jobs = response.data.jobs;

                    this.totalPages = Math.ceil(response.data.total / this.perPage);
                });
        },

        loadNewEntries() {
            this.jobs = [];

            this.fetchJobs(-1, false);

            this.hasNewEntries = false;
        },

        refreshJobsPeriodically() {
            this.interval = setInterval(() => {
                if (this.page !== 1) {
                    return;
                }

                this.fetchJobs(-1, true);
            }, 3000);
        },

        previous() {
            this.fetchJobs(
                (this.page - 2) * this.perPage
            );

            this.page -= 1;

            this.hasNewEntries = false;
        },

        next() {
            this.fetchJobs(
                this.page * this.perPage
            );

            this.page += 1;

            this.hasNewEntries = false;
        },

        getUrl(uri = '') {
            return this.instance.url.trimEnd('/') + uri;
        },
    }
}
</script>
