<script setup>
import Badge from "@/Components/Badge.vue";

defineProps({
    status: String,
});

const statusColorMap = {
    in_progress: "primary",
    ready: "success",
    returned: "secondary",
};
</script>

<template>
    <Badge :theme="statusColorMap[status]">
        {{ status }}
    </Badge>
</template>
