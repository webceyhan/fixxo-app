<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <component
        :is="$attrs.href ? Link : 'li'"
        class="flex justify-between items-center px-4 py-6 sm:p-6"
        :class="{ 'hover:bg-gray-200 dark:hover:bg-gray-700': $attrs.href }"
    >
        <slot />

        <!-- chevron-right icon -->
        <svg
            v-if="$attrs.href"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-4 h-4 opacity-50 -mr-1"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
        </svg>
    </component>
</template>
