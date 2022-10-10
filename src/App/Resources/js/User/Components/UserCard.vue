<template>
    <div class="rounded-lg bg-white shadow">
        <div class="flex w-full items-center justify-between space-x-6 p-6">
            <div class="flex-1 truncate">
                <div class="flex items-center space-x-3">
                    <h3 class="truncate text-md font-medium text-gray-900">{{ user.name }}</h3>
<!--                    <span class="inline-block flex-shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ person.role }}</span>-->
                </div>
                <p class="mt-1 truncate text-sm text-gray-500">{{ user.email }}</p>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                <span class="text-lg font-medium leading-none text-white">
                    {{ initial }}
                </span>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object
    },

    computed: {
        initial() {
            const parts = this.user.name.split(' ');

            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }

            return this.user.name.substring(0, 2).toUpperCase();
        }
    }
}
</script>
