<template>
    <Layout current="Users">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold leading-tight tracking-tight text-gray-900">User Detail</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-5xl mt-5">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Replace with your content -->
                <div class="space-y-10 divide-y divide-gray-900/10">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal information</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                User profile and email information.
                            </p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <UserInformationForm :url="route('user.update', { user: user.id })" :user="user" error-bag="updateUserInformation" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Reset password</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Reset user password associated with the account.</p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <ResetPassword :new-password="newPassword" :url="route('user.generate_password', { user: user.id })" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Delete user</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                You can delete user account here. This action is not reversible. All information related to this account will be deleted permanently.
                            </p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <Delete :url="route('user.delete', { user: user.id })" />
                        </div>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "@/Shared/Layouts/StackedLayout.vue";
import UserInformationForm from "@/User/Components/UserInformationForm.vue";
import ResetPassword from "@/User/Containers/ResetPassword.vue";
import Delete from "@/User/Containers/Delete.vue";

defineProps({
    user: Object,
    newPassword: String,
})
</script>
