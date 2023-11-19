<script setup>
import Layout from '../../Shared/Layouts/StackedLayout'
import UserCard from "@/User/Components/UserCard";
import CreateUser from "@/User/Containers/Create";
import {Link} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import InputSecret from "@/Shared/Components/InputSecret.vue";
import SuccessDialog from "@/Shared/Components/SuccessDialog.vue";

defineProps({
    users: Array,
    newPassword: String,
})

const showCreate = ref(false);
</script>

<template>
    <Layout current="Users">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold leading-tight tracking-tight text-gray-900">Users</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button @click="showCreate = true" type="button" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            New User
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <div class="mx-auto max-w-5xl mt-5">
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <li v-for="user in users" :key="user.id" class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                    <Link :href="route('user.show', { user: user.id })">
                        <user-card :user="user" />
                    </Link>
                </li>
            </ul>
        </div>

        <create-user :show="showCreate" @closed="showCreate = false" />

        <SuccessDialog @close="newPassword = null" :show="!!newPassword" title="User password">
            <div class="p-2">
                <div class="text-sm text-gray-500">
                    Here is user password. This password will not shown again after this dialog closed. Please copy it before close this dialog.
                </div>
                <div class="mt-5">
                    <InputSecret v-model="newPassword" />
                </div>
            </div>
        </SuccessDialog>
    </Layout>
</template>
