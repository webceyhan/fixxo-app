<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import TaskList from "./Partials/TaskList.vue";
import Card from "@/Components/Card.vue";

defineProps({
    tasks: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <Pagination v-bind="tasks" />
            </div>
        </template>

        <Card>
            <TaskList :tasks="tasks.data" />
        </Card>
    </AuthenticatedCrudLayout>
</template>
