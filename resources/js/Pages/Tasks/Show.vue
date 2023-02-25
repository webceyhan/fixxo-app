<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="task.description">
        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in task"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
