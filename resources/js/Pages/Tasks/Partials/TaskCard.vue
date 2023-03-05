<script setup>
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import TaskBadge from "./TaskBadge.vue";

defineProps({
    task: Object,
});
</script>

<template>
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

            <DescriptionListItem label="Status">
                <TaskBadge :status="task.status" />
            </DescriptionListItem>

            <DescriptionListItem
                label="Created At"
                type="date"
                :value="task.created_at"
            />
        </DescriptionList>
    </Card>
</template>
