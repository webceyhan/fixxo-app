<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    users: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Users">
        <Pagination v-bind="users" />

        <br />

        <StackedList>
            <StackedListItem
                v-for="user in users.data"
                :key="user.id"
                :href="route('users.show', user.id)"
            >
                {{ user.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
