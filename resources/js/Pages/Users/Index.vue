<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UserList from "./Partials/UserList.vue";
import Card from "@/Components/Card.vue";

defineProps({
    users: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedLayout title="Users">
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

        <Card flush>
            <UserList :users="users.data" />
        </Card>
    </AuthenticatedLayout>
</template>
