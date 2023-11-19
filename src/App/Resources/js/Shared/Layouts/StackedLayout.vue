<template>
    <div class="min-h-full pb-5">
        <Disclosure as="nav" class="bg-indigo-600" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10" :src="$page.props.app_logo"
                                 alt="Your Company"/>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <Link v-for="item in navigation" :href="item.href"
                                      :class="[item.current ? 'bg-indigo-700 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75', 'px-3 py-2 rounded-md text-sm font-medium']"
                                      :aria-current="item.current ? 'page' : undefined">
                                    {{ item.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton
                                        class="flex max-w-xs items-center rounded-full bg-indigo-600 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-50">
                                            <span class="text-lg font-medium leading-none text-gray-600">
                                                {{ initial }}
                                            </span>
                                        </span>
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                            <a :href="item.href"
                                               :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{
                                                    item.name
                                                }}</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton
                            class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-2 text-indigo-200 hover:bg-indigo-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true"/>
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                                      :class="[item.current ? 'bg-indigo-700 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75', 'block px-3 py-2 rounded-md text-base font-medium']"
                                      :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                    </DisclosureButton>
                </div>
                <div class="border-t border-indigo-700 pt-4 pb-3">
                    <div v-if="user" class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-50">
                                <span class="text-lg font-medium leading-none text-gray-600">
                                    {{ initial }}
                                </span>
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ $page.props.user.name }}</div>
                            <div class="text-sm font-medium text-indigo-300">{{ $page.props.user.email  }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"
                                          class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75">
                            {{ item.name }}
                        </DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <main>
            <slot/>
        </main>

        <SuccessDialog v-if="$page.props.message.success" @close="$page.props.message.success = null" title="Action succeed" :show="true">
            <p class="p-2 text-sm text-gray-500">
                {{ $page.props.message.success }}
            </p>
        </SuccessDialog>

        <ErrorDialog v-if="$page.props.message.error" @close="$page.props.message.error = null" :show="true">
            <p class="p-2 text-sm text-gray-500">
                {{ $page.props.message.error }}
            </p>
        </ErrorDialog>
    </div>
</template>

<script>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, BellIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/outline'
import {Link} from "@inertiajs/inertia-vue3";
import SuccessDialog from "@/Shared/Components/SuccessDialog.vue";
import ErrorDialog from "@/Shared/Components/ErrorDialog.vue";

export default {
    components: {
        ErrorDialog,
        SuccessDialog,
        Link,

        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,

        Bars3Icon,
        BellIcon,
        XMarkIcon,
        PlusIcon
    },

    props: {
        current: String,
    },

    data() {
        return {
            navigation: [
                {name: 'Instances', href: '/instances', current: false},
                {name: 'Users', href: '/users', current: false},
                {name: 'Environments', href: '/environments', current: false},
            ],
            userNavigation: [
                //{name: 'Your Profile', href: '#'},
                //{name: 'Settings', href: '#'},
                {name: 'Sign out', href: '/auth/logout'},
            ]
        };
    },

    mounted() {
        for (let nav of this.navigation) {
            if (nav.name === this.current) {
                nav.current = true;

                continue;
            }

            nav.current = false;
        }
    },

    computed: {
        initial() {
            const parts = this.$page.props.user.name.split(' ');

            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }

            return this.$page.props.user.name.substring(0, 2).toUpperCase();
        }
    }
}
</script>
