<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    users: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Users">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <PrimaryButton
                    label="New"
                    :href="route('users.create')"
                    class="ml-5 mr-auto"
                />
                <Pagination v-bind="users" />
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="user in users.data"
                :key="user.id"
                :href="route('users.show', user.id)"
            >
                <span class="w-2/5">
                    {{ user.name }}
                </span>
                <span class="w-1/5 text-gray-400">
                    assets {{ user.assets_count }}
                </span>
                <span class="w-1/5 text-gray-400">
                    tasks {{ user.tasks_count }}
                </span>
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
