<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

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

        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in user"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
