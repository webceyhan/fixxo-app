<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    customer: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="customer.name">
        <template #actions>
            <div class="flex justify-end items-center gap-2">
                <SecondaryButton
                    label="Edit"
                    :href="route('customers.edit', customer.id)"
                />
            </div>
        </template>

        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in customer"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
