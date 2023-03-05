<script setup>
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import CustomerBadge from "./CustomerBadge.vue";

const props = defineProps({
    customer: Object,
});
</script>

<template>
    <Card label="Customer">
        <DescriptionList>
            <DescriptionListItem label="Name" :value="customer.name" />

            <DescriptionListItem
                v-if="customer.company"
                label="Company"
                :value="customer.company"
            />

            <DescriptionListItem
                v-if="customer.vat"
                label="VAT"
                :value="customer.vat"
            />

            <DescriptionListItem
                v-if="customer.phone"
                label="Phone"
                type="phone"
                :value="customer.phone"
            />

            <DescriptionListItem
                v-if="customer.email"
                label="Email"
                type="email"
                :value="customer.email"
            />

            <DescriptionListItem
                v-if="customer.address"
                label="Address"
                type="location"
                :value="customer.address"
            />

            <DescriptionListItem label="Status">
                <CustomerBadge :status="customer.status" />
            </DescriptionListItem>

            <DescriptionListItem
                label="Created At"
                type="date"
                :value="customer.created_at"
            />

            <DescriptionListItem
                label="Last Update"
                type="date"
                :value="customer.updated_at"
            />
        </DescriptionList>
    </Card>
</template>
