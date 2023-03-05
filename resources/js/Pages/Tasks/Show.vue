<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskCard from "./Partials/TaskCard.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <AuthenticatedLayout :title="task.description">
        <Toolbar>
            <BackButton class="mr-auto" />

            <SecondaryButton
                label="Edit"
                :href="route('tasks.edit', task.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('tasks.destroy', task.id)"
            />
        </Toolbar>

        <TaskCard :task="task" />
    </AuthenticatedLayout>
</template>
