<template>
    <SideBarLayout :instance="instance" current="Settings">
        <template v-slot:header>
            <h1 class="text-lg font-semibold text-gray-900 mr-3">Settings</h1>
        </template>
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Replace with your content -->
                <div class="space-y-10 divide-y divide-gray-900/10">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Instance details</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">This instance information and connection.</p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <InstanceForm error-bag="updateInstance"
                                          :url="route('instance.setting.update', { instance: instance.id })"
                                          :environments="environments"
                                          :instance="instance" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Client secret</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Regenerate client secret action is permanently and cannot be undone.</p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <SecretForm error-bag="updateInstance"
                                          :url="route('instance.setting.regenerate', { instance: instance.id })"
                                          :instance="instance" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Delete instance</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                No longer want to use this instance? You can delete your instance here.
                            </p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <DeleteInstance :url="route('instance.setting.delete', { instance: instance.id })" />
                        </div>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </div>
    </SideBarLayout>
</template>

<script setup>
import SideBarLayout from "@/Shared/Layouts/SideBarLayout.vue";
import InstanceForm from "@/Instance/Components/InstanceForm.vue";
import SecretForm from "@/Instance/Components/SecretForm.vue";
import DeleteInstance from "@/Instance/Components/DeleteInstance.vue";

defineProps({
    instance: Object,
    environments: Array,
})
</script>
