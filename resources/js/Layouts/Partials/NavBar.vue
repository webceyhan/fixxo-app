<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { isAdmin } from "@/Shared/auth";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "./NavLink.vue";
import ResponsiveNavLink from "./ResponsiveNavLink.vue";

const props = defineProps({
    user: Object,
});

const toggled = ref(false);

const links = [
    {
        label: "New",
        // icon: "create",
        to: "customers.create",
    },
    {
        label: "Dashboard",
        // icon: "dashboard",
        to: "dashboard",
        admin: true,
    },
    {
        label: "Customers",
        // icon: "customer",
        to: "customers.index",
    },
    {
        label: "Assets",
        // icon: "asset",
        to: "assets.index",
    },
    {
        label: "Tasks",
        // icon: "task",
        to: "tasks.index",
        // class: "hidden md:inline-flex",
    },
    {
        label: "Payments",
        // icon: "payment",
        to: "payments.index",
        // class: "hidden md:inline-flex",
    },
    {
        label: "Users",
        // icon: "user",
        to: "users.index",
        // class: "hidden md:inline-flex",
        admin: true,
    },
];

const allowedLinks = computed(() =>
    links.filter(({ admin }) => !(admin && !isAdmin.value))
);
</script>

<template>
    <nav
        class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
    >
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <NavLink
                            v-for="(link, index) in allowedLinks"
                            :key="index"
                            :href="route(link.to)"
                            :active="route().current(link.to)"
                            :class="link.class"
                        >
                            {{ link.label }}
                        </NavLink>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        @click="toggled = !toggled"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                    hidden: toggled,
                                    'inline-flex': !toggled,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !toggled,
                                    'inline-flex': toggled,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{
                block: toggled,
                hidden: !toggled,
            }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink
                    v-for="(link, index) in allowedLinks"
                    :key="index"
                    :href="route(link.to)"
                    :active="route().current(link.to)"
                    :class="link.class"
                >
                    {{ link.label }}
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div
                class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600"
            >
                <div class="px-4">
                    <div
                        class="font-medium text-base text-gray-800 dark:text-gray-200"
                    >
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
