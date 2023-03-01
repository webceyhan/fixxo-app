<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import TaskList from "./Partials/TaskList.vue";

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

        <TaskList :tasks="tasks.data" />
    </AuthenticatedCrudLayout>
</template>
