<script setup>
import BaseButton from "./BaseButton.vue";
</script>

<template>
    <BaseButton
        type="submit"
        class="bg-red-600 text-white border-transparent hover:bg-red-500 active:bg-red-700 focus:ring-red-500"
    >
        <slot />
    </BaseButton>
</template>
