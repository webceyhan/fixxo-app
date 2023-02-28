<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    payment: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="payment.type">
        <template #actions>
            <div class="flex justify-end items-center gap-2">
                <SecondaryButton
                    label="Edit"
                    :href="route('payments.edit', payment.id)"
                />
            </div>
        </template>

        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in payment"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
