<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskCard from "./Partials/TaskCard.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <PageLayout :title="task.description">
        <template #toolbar>
            <SecondaryButton
                label="Edit"
                :href="route('tasks.edit', task.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('tasks.destroy', task.id)"
            />
        </template>

        <template #aside>
            <AssetCard :asset="task.asset" />
        </template>

        <template #content>
            <TaskCard :task="task" />
        </template>
    </PageLayout>
</template>
