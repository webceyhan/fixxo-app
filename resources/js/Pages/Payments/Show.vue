<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import Card from "@/Components/Card.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

defineProps({
    payment: Object,
});
</script>

<template>
    <AuthenticatedLayout :title="payment.type">
        <Toolbar>
            <BackButton class="mr-auto" />

            <SecondaryButton
                label="Edit"
                :href="route('payments.edit', payment.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('payments.destroy', payment.id)"
            />
        </Toolbar>

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
    </AuthenticatedLayout>
</template>
