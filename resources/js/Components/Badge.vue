<script setup>
defineProps({
    primary: Boolean,
    success: Boolean,
    warning: Boolean,
    danger: Boolean,
});
</script>

<template>
    <span
        class="text-sm rounded-full text-gray-200 dark:text-gray-300 px-2.5 py-0.5"
        :class="{
            // default color (secondary)
            'bg-gray-200 dark:bg-gray-900 dark:bg-opacity-50':
                !primary && !success && !warning && !danger,

            // primary
            'bg-blue-100 text-blue-800 dark:bg-blue-800': primary,

            // success
            'bg-green-100 text-green-800 dark:bg-green-800': success,

            // warning
            'bg-yellow-100 text-yellow-800 dark:bg-yellow-800': warning,

            // danger
            'bg-red-100 text-red-800 dark:bg-red-800': danger,
        }"
    >
        <slot />
    </span>
</template>
