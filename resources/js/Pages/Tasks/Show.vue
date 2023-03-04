<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Card from "@/Components/Card.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <AuthenticatedLayout :title="task.description">
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

        <Card label="Overview">
            <DescriptionList>
                <!-- TODO: Add the following fields as link -->
                <!-- asset_id: Asset -->
                <!-- user_id: Assignee -->

                <DescriptionListItem
                    label="Description"
                    :value="task.description"
                />

                <DescriptionListItem
                    label="Price"
                    type="money"
                    :value="task.price"
                />

                <DescriptionListItem label="Status" :value="task.status" />

                <DescriptionListItem
                    label="Created At"
                    type="date"
                    :value="task.created_at"
                />
            </DescriptionList>
        </Card>
    </AuthenticatedLayout>
</template>
