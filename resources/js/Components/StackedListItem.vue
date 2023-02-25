<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link
        v-if="$attrs.href"
        class="flex justify-between items-center p-4 hover:bg-gray-200- dark:hover:bg-gray-700 hover:border-transparent"
    >
        <slot />

        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-4 h-4"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
        </svg>
    </Link>

    <li v-else class="flex p-4">
        <slot />
    </li>
</template>

<style scoped>
    a:hover {
        border-color: transparent !important;
    }
</style>