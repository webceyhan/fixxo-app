<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import UserCard from "./Partials/UserCard.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <AuthenticatedLayout :title="user.name">
        <Toolbar>
            <BackButton class="mr-auto" />

            <SecondaryButton
                label="Edit"
                :href="route('users.edit', user.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('users.destroy', user.id)"
            />
        </Toolbar>

        <UserCard :user="user" />
    </AuthenticatedLayout>
</template>
