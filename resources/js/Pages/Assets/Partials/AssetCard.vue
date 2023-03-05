<script setup>
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";

const props = defineProps({
    asset: Object,
});
</script>

<template>
    <Card label="Overview">
        <DescriptionList>
            <!-- TODO: Add the following fields as link -->
            <!-- customer_id: Owner -->
            <!-- user_id: Receiver -->

            <DescriptionListItem label="Name" :value="asset.name" />

            <DescriptionListItem label="Brand" :value="asset.brand" />

            <DescriptionListItem label="Type" :value="asset.type" />

            <DescriptionListItem
                v-if="asset.serial_number"
                label="Serial Number"
                :value="asset.serial_number"
            />

            <!-- TODO: if purchase_date present, show warranty status
                        based on the calculated warranty date -->
            <DescriptionListItem
                v-if="asset.purchase_date"
                label="Purchase Date"
                type="date"
                :value="asset.purchase_date"
            />

            <DescriptionListItem
                v-if="asset.warranty"
                label="Warranty"
                :value="asset.warranty"
            />

            <DescriptionListItem label="Status" :value="asset.status" />

            <DescriptionListItem
                label="Created At"
                type="date"
                :value="asset.created_at"
            />

            <DescriptionListItem
                v-if="asset.returned_at"
                label="Returned At"
                type="date"
                :value="asset.returned_at"
            />

            <DescriptionListItem
                label="Last Update"
                type="date"
                :value="asset.updated_at"
            />
        </DescriptionList>
    </Card>
</template>
