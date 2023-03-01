<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Card from "@/Components/Card.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="user.name">
        <template #actions>
            <div class="flex justify-end items-center gap-2">
                <SecondaryButton
                    label="Edit"
                    :href="route('users.edit', user.id)"
                />
                <DangerButton
                    label="Delete"
                    method="delete"
                    :href="route('users.destroy', user.id)"
                />
            </div>
        </template>

        <Card>
            <DescriptionList>
                <DescriptionListItem label="Name" :value="user.name" />

                <DescriptionListItem label="Email" :value="user.email" />

                <DescriptionListItem label="Role" :value="user.role" />

                <DescriptionListItem label="Status" :value="user.status" />

                <DescriptionListItem
                    v-if="user.email_verified_at"
                    label="Email Verified At"
                    type="date"
                    :value="user.email_verified_at"
                />

                <DescriptionListItem
                    label="Created At"
                    type="date"
                    :value="user.created_at"
                />

                <DescriptionListItem
                    label="Last Update"
                    type="date"
                    :value="user.updated_at"
                />
            </DescriptionList>
        </Card>
    </AuthenticatedCrudLayout>
</template>
