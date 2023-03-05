<script setup>
import Badge from "@/Components/Badge.vue";

defineProps({
    status: String,
});

const statusColorMap = {
    active: "primary",
    inactive: "secondary",
};
</script>

<template>
    <Badge :theme="statusColorMap[status]">
        {{ status }}
    </Badge>
</template>
