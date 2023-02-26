<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";

defineProps({
    users: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Users">
        <div class="flex justify-between items-center">
            <Searchbar :filters="filters" />
            <Pagination v-bind="users" />
        </div>

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
