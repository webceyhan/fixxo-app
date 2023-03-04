<script setup>
import BaseButton from "./BaseButton.vue";
</script>

<template>
    <BaseButton
        type="submit"
        class="bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 border-transparent hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:ring-indigo-500"
    >
        <slot />
    </BaseButton>
</template>
