<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";

defineProps({
    tasks: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <div class="flex justify-between items-center">
            <Searchbar :filters="filters" />
            <Pagination v-bind="tasks" />
        </div>

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
