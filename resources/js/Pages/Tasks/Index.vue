<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    tasks: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <StackedList>
            <StackedListItem
                v-for="task in tasks"
                :key="task.id"
                :href="route('tasks.show', task.id)"
            >
                {{ task.description }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
