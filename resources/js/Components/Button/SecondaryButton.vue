<script setup>
import BaseButton from "./BaseButton.vue";
</script>

<template>
    <BaseButton
        class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-500 enabled:hover:bg-gray-50 enabled:dark:hover:bg-gray-700 focus:ring-indigo-500"
    >
        <slot />
    </BaseButton>
</template>
