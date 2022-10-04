<script type="text/ecmascript-6">
import _take from "lodash/take"

export default {
    props: ['trace'],

    /**
     * The component's data.
     */
    data() {
        return {
            minimumLines: 5,
            showAll: false,
        };
    },

    computed: {
        lines() {
            return this.showAll ? _take(this.trace, 1000) : _take(this.trace, this.minimumLines);
        }
    }
}
</script>

<template>
    <div class="bg-gray-800 text-md pb-2">
        <div class="py-2 px-4">
            <div class="py-2 text-white" v-for="line in lines">
                {{ line }}
            </div>

            <a @click="showAll = true" v-if="! showAll" class="mt-2 inline-flex items-center rounded-md bg-gray-600 px-2.5 py-0.5 text-sm font-medium text-gray-50 cursor-pointer">
                Show entire Stacktrace
            </a>
            <a @click="showAll = false" v-if="showAll" class="mt-2 inline-flex items-center rounded-md bg-gray-600 px-2.5 py-0.5 text-sm font-medium text-gray-50 cursor-pointer">
                Show less Stacktrace
            </a>
        </div>
    </div>
</template>
