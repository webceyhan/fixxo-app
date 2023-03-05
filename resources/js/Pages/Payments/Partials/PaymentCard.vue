<script setup>
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";

defineProps({
    payment: Object,
});
</script>

<template>
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
</template>
