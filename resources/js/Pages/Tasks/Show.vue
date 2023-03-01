<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Card from "@/Components/Card.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="task.description">
        <template #actions>
            <div class="flex justify-end items-center gap-4">
                <SecondaryButton
                    label="Edit"
                    :href="route('tasks.edit', task.id)"
                />
                <DangerButton
                    label="Delete"
                    method="delete"
                    :href="route('tasks.destroy', task.id)"
                />
            </div>
        </template>

        <Card>
            <DescriptionList>
                <DescriptionListItem
                    v-for="(value, label) in task"
                    :key="label"
                    v-bind="{ label, value }"
                />
            </DescriptionList>
        </Card>
    </AuthenticatedCrudLayout>
</template>
