<script setup>
defineProps({
    label: String,
});
</script>

<template>
    <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
        <slot name="header">
            <h2
                v-if="label"
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6"
            >
                {{ label }}
            </h2>
        </slot>

        <div class="text-gray-900 dark:text-gray-100">
            <slot />
        </div>
    </div>
</template>
