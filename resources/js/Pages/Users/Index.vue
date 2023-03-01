<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
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

        <Card>
            <UserList :users="users.data" />
        </Card>
    </AuthenticatedCrudLayout>
</template>
