<template>
    <div class="flex flex-shrink-0">
        <p v-if="connecting" class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
            Connecting
        </p>
        <template v-else>
            <p v-if="running" class="inline-flex items-center rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
            <span class="flex h-2 w-2 mr-1 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-300 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
                Running
            </p>
            <p v-if="!running" class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                Not Running
            </p>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        connecting: Boolean,
        running: Boolean,
    }
}
</script>
