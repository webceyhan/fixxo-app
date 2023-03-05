<script setup>
import Badge from "@/Components/Badge.vue";

defineProps({
    status: String,
});

const statusColorMap = {
    pending: "warning",
    done: "success",
};
</script>

<template>
    <Badge :theme="statusColorMap[status]">
        {{ status }}
    </Badge>
</template>
