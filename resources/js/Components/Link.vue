<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    label: String,
    native: Boolean,
    secondary: Boolean,
    outline: Boolean,
    small : Boolean,
});
</script>

<template>
    <component
        :is="native ? 'a' : Link"
        :class="{
            // text
            'text-sm font-medium': small,

            // primary (default)
            'text-indigo-500 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200':
                !outline && !secondary,

            // secondary
            'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100':
                !outline && secondary,

            // outline
            'border-b border-dashed border-gray-500': outline,
        }"
    >
        <slot> {{ label }} </slot>
    </component>
</template>
