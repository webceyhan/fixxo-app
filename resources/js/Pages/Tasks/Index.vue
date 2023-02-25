<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    tasks: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <Pagination v-bind="tasks" />

        <br />

        <StackedList>
            <StackedListItem
                v-for="task in tasks.data"
                :key="task.id"
                :href="route('tasks.show', task.id)"
            >
                {{ task.description }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
