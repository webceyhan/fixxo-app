<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    users: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Users">
        <StackedList>
            <StackedListItem
                v-for="user in users"
                :key="user.id"
                :href="route('users.show', user.id)"
            >
                {{ user.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
