<script setup>
import Card from "./Card.vue";

defineProps({
    label: String,
});
</script>

<template>
    <Card class="border-slate-500 border-l-4">
        <slot />
    </Card>
</template>
