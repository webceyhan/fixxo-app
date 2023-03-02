<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Card from "@/Components/Card.vue";

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
                <DangerButton
                    label="Delete"
                    method="delete"
                    :href="route('payments.destroy', payment.id)"
                />
            </div>
        </template>

        <Card label="Overview">
            <DescriptionList>
                <!-- TODO: Add the following fields as link -->
                <!-- asset_id: Asset -->
                <!-- user_id: Taker -->

                <DescriptionListItem
                    label="Amount"
                    type="money"
                    :value="payment.amount"
                />

                <DescriptionListItem label="Type" :value="payment.type" />

                <DescriptionListItem label="Method" :value="payment.method" />

                <DescriptionListItem
                    v-if="payment.notes"
                    label="Notes"
                    :value="payment.notes"
                />

                <DescriptionListItem
                    label="Created At"
                    type="date"
                    :value="payment.created_at"
                />
            </DescriptionList>
        </Card>
    </AuthenticatedCrudLayout>
</template>
